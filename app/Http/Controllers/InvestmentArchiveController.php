<?php

namespace App\Http\Controllers;

use App\Models\InvestmentArchive;
use App\Models\Bandwidth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Exports\InvestmentExport;
use Maatwebsite\Excel\Facades\Excel;
// use App\Models\InvestmentArchive;

class InvestmentArchiveController extends Controller
{
    /**
     * Display a listing of the archived calculations for users.
     */
     public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $perPage = request('per_page', 10);
        $search = request('search');

        $allowedPerPage = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $query = InvestmentArchive::with('user')
            ->when(request('viability') === 'layak', function ($query) {
                return $query->where('is_viable', true);
            })
            ->when(request('viability') === 'tidak-layak', function ($query) {
                return $query->where('is_viable', false);
            });

        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        } elseif ($user->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('calculation_date', 'like', "%{$search}%")
                  ->orWhere('capex', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('total_revenue', 'like', "%{$search}%")
                  ->orWhere('npv', 'like', "%{$search}%")
                  ->orWhere('irr', 'like', "%{$search}%")
                  ->orWhere('payback_period', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $archives = $query->orderBy('calculation_date', 'desc')
                         ->paginate($perPage)
                         ->appends(request()->query());

        $view = $user->role === 'superadmin' ? 'superadmin.archive.index' : 'user.archive.index';

        return view($view, compact('archives'));
    }

    

    /**
     * Display the specified archived calculation.
     */
    public function show(InvestmentArchive $archive)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->role === 'user' && $archive->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this archive.');
        }

        $archive->load('user');
        $cashFlows = is_string($archive->cash_flows) ? json_decode($archive->cash_flows, true) : $archive->cash_flows;
        $cashFlows = $cashFlows ?? [];
        
        if ($user->role === 'superadmin') {
            return view('superadmin.archive.show', compact('archive', 'cashFlows'));
        } else {
            return view('user.archive.show', compact('archive', 'cashFlows'));
        }
    }

    /**
     * Show the form for editing the specified archive.
     */
    public function edit(InvestmentArchive $archive)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->role === 'user' && $archive->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this archive.');
        }

        $items = \App\Models\Item::with('bandwidths')->get();

        return view('user.archive.edit', compact('archive', 'items'));
    }

    /**
     * Update the specified archive.
     */
    public function update(Request $request, InvestmentArchive $archive)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'user' && $archive->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this archive.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255', // Add this line
            'capex_raw' => 'required|numeric|min:0',
            'opex_percentage' => 'required|numeric|min:0|max:100',
            'wacc_percentage' => 'required|numeric|min:0|max:100',
            'bhp_percentage' => 'required|numeric|min:0|max:100',
            'minimal_irr_percentage' => 'required|numeric|min:0|max:100',
            'items' => 'sometimes|array',
            'items.*.item_id' => 'required_with:items|exists:items,id',
            'items.*.bandwidth_id' => 'required_with:items|exists:bandwidths,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.duration' => 'required_with:items|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            // Convert inputs to float
            $capex = (float)$validated['capex_raw'];
            $opexPercentage = (float)$validated['opex_percentage'];
            $waccPercentage = (float)$validated['wacc_percentage'];
            $bhpPercentage = (float)$validated['bhp_percentage'];
            $minimalIrrPercentage = (float)$validated['minimal_irr_percentage'];

            $updateData = [
                'customer_name' => $validated['customer_name'], // Add this line
                'capex' => $capex,
                'opex_percentage' => $opexPercentage,
                'wacc_percentage' => $waccPercentage,
                'bhp_percentage' => $bhpPercentage,
                'minimal_irr_percentage' => $minimalIrrPercentage,
                'updated_at' => now(),
            ];

            // Calculate total revenue if items are provided
            $totalRevenue = 0;
            if (isset($validated['items'])) {
                // Hapus items lama sebelum menambah yang baru
                $archive->items()->delete();
                
                foreach ($request->items as $itemData) {
                    $bandwidth = Bandwidth::findOrFail($itemData['bandwidth_id']);
                    $itemRevenue = $bandwidth->price * $itemData['quantity'] * $itemData['duration'];
                    $totalRevenue += $itemRevenue;
                    
                    // Update atau create item baru
                    $archive->items()->create([
                        'item_id' => $itemData['item_id'],
                        'bandwidth_id' => $itemData['bandwidth_id'],
                        'quantity' => $itemData['quantity'],
                        'duration' => $itemData['duration'],
                        'price' => $bandwidth->price
                    ]);
                }

                $updateData['total_revenue'] = $totalRevenue;
            } else {
                // Use existing total revenue if items aren't updated
                $totalRevenue = $archive->total_revenue;
            }

            // Recalculate financial metrics
            $depreciation = $capex / 3;
            $cashFlows = [-$capex]; // Year 0: Initial investment
            
            // Calculate cash flows for years 1-3
            for ($year = 1; $year <= 3; $year++) {
                $opex = ($opexPercentage / 100) * $capex;
                $bhp = ($bhpPercentage / 100) * $totalRevenue;
                $ebitda = $totalRevenue - $opex - $bhp;
                $ebit = $ebitda - $depreciation;
                $taxes = max(0, $ebit * 0.30);
                $nopat = $ebit - $taxes;
                $netCashFlow = $nopat + $depreciation;
                
                $cashFlows[] = $netCashFlow;
            }
            
            // Calculate NPV, IRR, and Payback Period
            $npv = $this->calculateProperNPV($cashFlows, $waccPercentage / 100);
            $irr = $this->calculateProperIRR($cashFlows);
            $paybackPeriod = $this->calculatePaybackPeriod($cashFlows, $minimalIrrPercentage);

            // Add calculated values to update data
            $updateData = array_merge($updateData, [
                'depreciation' => $depreciation,
                'npv' => $npv,
                'irr' => $irr * 100, // Convert to percentage
                'payback_period' => $paybackPeriod,
                'is_viable' => ($irr * 100) >= $minimalIrrPercentage,
                'cash_flows' => json_encode($cashFlows),
            ]);

            // Update archive
            $archive->update(array_merge($updateData, [
                'notes' => $validated['notes'], // Add this line
            ]));

            DB::commit();

            return redirect()->route($user->role === 'superadmin' 
                ? 'superadmin.investment.archive.index' 
                : 'user.investment.archive.index')
                ->with('success', 'Archive updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update archive: ' . $e->getMessage());
        }
    }

    // Add these helper methods to the controller
    private function calculateProperNPV(array $cashFlows, float $discountRate): float
    {
        $npv = 0;
        foreach ($cashFlows as $t => $cf) {
            $npv += $cf / pow(1 + $discountRate, $t);
        }
        return $npv;
    }

    private function calculateProperIRR(array $cashFlows, float $guess = 0.1): float
    {
        $maxIteration = 1000;
        $tolerance = 0.00001;
        
        for ($i = 0; $i < $maxIteration; $i++) {
            $npv = 0;
            $derivative = 0;
            
            foreach ($cashFlows as $t => $cf) {
                $npv += $cf / pow(1 + $guess, $t);
                if ($t > 0) {
                    $derivative -= $t * $cf / pow(1 + $guess, $t + 1);
                }
            }
            
            if (abs($npv) < $tolerance) {
                return $guess;
            }
            
            if (abs($derivative) < $tolerance) {
                break;
            }
            
            $newGuess = $guess - ($npv / $derivative);
            
            if ($newGuess <= -1) {
                $newGuess = $guess / 2;
            }
            
            $guess = $newGuess;
        }
        
        return $guess;
    }

    private function calculatePaybackPeriod(array $cashFlows, float $minimalIrrPercentage): string
    {
        $discountRate = $minimalIrrPercentage / 100;
        $discounted = [];
        foreach ($cashFlows as $t => $cf) {
            $discounted[] = $cf / pow(1 + $discountRate, $t);
        }

        // Hitung cumulative discounted net cash flow
        $cumulativeFlows = [];
        $cumulative = 0;
        foreach ($discounted as $cf) {
            $cumulative += $cf;
            $cumulativeFlows[] = $cumulative;
        }

        // Cari years sesuai rumus
        $years = 0;
        if (isset($cumulativeFlows[1], $cumulativeFlows[2]) && $cumulativeFlows[1] < 0 && $cumulativeFlows[2] >= 0) {
            $years = 1;
        } elseif (isset($cumulativeFlows[2], $cumulativeFlows[3]) && $cumulativeFlows[2] < 0 && $cumulativeFlows[3] >= 0) {
            $years = 2;
        }

        // Hitung months proporsional
        $months = 0;
        if ($years === 1 && isset($cumulativeFlows[1], $cumulativeFlows[2])) {
            $months = (-$cumulativeFlows[1] / ($cumulativeFlows[2] - $cumulativeFlows[1])) * 12;
        } elseif ($years === 2 && isset($cumulativeFlows[2], $cumulativeFlows[3])) {
            $months = (-$cumulativeFlows[2] / ($cumulativeFlows[3] - $cumulativeFlows[2])) * 12;
        }
        $months = round($months);

        // Handle special case where months calculation results in 12
        if ($months === 12) {
            $years++;
            $months = 0;
        }

        // Format hasil
        if ($years === 0 && $months === 0) {
            return "Investasi belum kembali dalam 3 tahun";
        } else {
            $totalMonths = $years * 12 + $months;
            $newYears = floor($totalMonths / 12);
            $newMonths = $totalMonths % 12;
            $result = '';
            if ($newYears > 0) $result .= $newYears . ' tahun ';
            if ($newMonths > 0) $result .= $newMonths . ' bulan';
            return trim($result);
        }
    }

    // app/Http/Controllers/InvestmentArchiveController.php


    public function export(InvestmentArchive $archive)
    {
        $filename = 'AKI-Evaluation-' . $archive->id . '-' . now()->format('YmdHis') . '.xlsx';
        
        return Excel::download(new InvestmentExport($archive), $filename);
    }

    /**
     * Remove the specified archived calculation.
     */
    public function destroy(InvestmentArchive $archive)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        
        if ($user->role === 'user' && $archive->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();
        try {
            $archive->items()->delete();
            $archive->delete();
            
            DB::commit();

            return response()->json(['success' => true]);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete archive: ' . $e->getMessage()], 500);
        }
    }
}