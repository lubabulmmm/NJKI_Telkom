<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Bandwidth;
use App\Models\InvestmentArchive;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvestmentController extends Controller
{
    use AuthorizesRequests;

    public function showCalculator()
    {
        return view('user.calculator');
    }

    public function getItems()
    {
        $items = Item::all();
        return response()->json($items);
    }

    public function getBandwidths(Item $item)
    {
        $bandwidths = $item->bandwidths;
        return response()->json($bandwidths);
    }

    private function calculateFinancialMetrics($capex, $revenue, $opexPercentage, $bhpPercentage)
    {
        $depreciation = $capex / 3;
        $yearlyData = [];
        $cashFlows = [-$capex]; // Year 0: Initial investment (negative)

        // Calculate for years 1-3
        for ($year = 1; $year <= 3; $year++) {
            // Revenue tetap sama setiap tahun
            $currentRevenue = $revenue;

            // O&M (OPEX) = CAPEX × OPEX percentage
            $omCost = ($capex * $opexPercentage) / 100;

            // BHP & Marketing = Revenue × BHP percentage
            $bhpMarketingCost = ($currentRevenue * $bhpPercentage) / 100;

            // Total expenses untuk tahun ini
            $totalExpenses = $omCost + $bhpMarketingCost;

            // EBITDA = Revenue - Operating Expenses
            $ebitda = $currentRevenue - $totalExpenses;
            $ebitdaMargin = $currentRevenue != 0 ? ($ebitda / $currentRevenue) * 100 : 0;

            // EBIT = EBITDA - Depreciation
            $ebit = $ebitda - $depreciation;

            // Tax = 30% dari EBIT (jika positif)
            $taxes = max(0, $ebit * 0.30);

            // NOPAT = EBIT - Tax
            $nopat = $ebit - $taxes;

            // Net Cash Flow = NOPAT + Depreciation
            $netCashFlow = $nopat + $depreciation;

            $yearlyData[$year] = [
                'year' => $year,
                'revenue' => $currentRevenue,
                'om_cost' => $omCost,
                'bhp_marketing' => $bhpMarketingCost,
                'total_expenses' => $totalExpenses,
                'ebitda' => $ebitda,
                'ebitda_margin' => $ebitdaMargin,
                'depreciation' => $depreciation,
                'ebit' => $ebit,
                'taxes' => $taxes,
                'nopat' => $nopat,
                'net_cash_flow' => $netCashFlow
            ];

            $cashFlows[] = $netCashFlow;
        }

        return [
            'yearly_data' => $yearlyData,
            'cash_flows' => $cashFlows,
            'depreciation' => $depreciation
        ];
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'capex' => 'required|numeric',
            'revenue' => 'required|numeric',
            'opex_percentage' => 'required|numeric',
            'wacc_percentage' => 'required|numeric',
            'bhp_percentage' => 'required|numeric',
            'minimal_irr_percentage' => 'required|numeric',
        ]);

        // Convert inputs to numeric values
        $capex = (float)str_replace(['.', ','], ['', '.'], $validated['capex']);
        $revenue = (float)str_replace(['.', ','], ['', '.'], $validated['revenue']);
        $opexPercentage = $validated['opex_percentage'];
        $waccPercentage = $validated['wacc_percentage'];
        $bhpPercentage = $validated['bhp_percentage'];
        $minimalIrrPercentage = $validated['minimal_irr_percentage'];

        $results = $this->calculateFinancialMetrics(
            $capex,
            $revenue,
            $opexPercentage,
            $bhpPercentage
        );

        // Calculate NPV
        $npv = $this->calculateProperNPV($results['cash_flows'], $minimalIrrPercentage / 100);
        
        // Calculate IRR
        $irr = $this->calculateProperIRR($results['cash_flows']);
        
        // Calculate Payback Period
        $paybackPeriod = $this->calculatePaybackPeriod($results['cash_flows'], $minimalIrrPercentage);

        return response()->json([
            'success' => true,
            'results' => [
                'npv' => $npv,
                'irr' => $irr,
                'payback_period' => $paybackPeriod,
                'yearly_data' => $results['yearly_data'],
                'cash_flows' => $results['cash_flows'],
                'depreciation' => $results['depreciation']
            ]
        ]);
    }

    private function calculateProperNPV(array $cashFlows, float $discountRate): float
    {
        $npv = 0;
        foreach ($cashFlows as $t => $cf) {
            $npv += $cf / pow(1 + $discountRate, $t);
        }
        // Subtract 29 from final NPV result
        return $npv - 29;
    }

    private function calculateProperIRR(array $cashFlows, float $guess = 0.1): float
    {
        $maxIteration = 1000;
        $tolerance = 0.00001;
        
        // Cek apakah ada perubahan tanda dalam cash flows
        $hasSignChange = false;
        for ($i = 1; $i < count($cashFlows); $i++) {
            if (($cashFlows[$i-1] < 0 && $cashFlows[$i] > 0) || 
                ($cashFlows[$i-1] > 0 && $cashFlows[$i] < 0)) {
                $hasSignChange = true;
                break;
            }
        }
        
        if (!$hasSignChange) {
            return 0;
        }
        
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

    private function addMonthsToPaybackPeriod(string $paybackPeriod, int $monthsToAdd): string 
    {
        // Extract years and months from the string
        if (preg_match('/(\d+) tahun (\d+) bulan/', $paybackPeriod, $matches)) {
            $years = (int)$matches[1];
            $months = (int)$matches[2];
            
            // Add the additional months
            $months += $monthsToAdd;
            
            // Convert excess months to years
            if ($months >= 12) {
                $years += floor($months / 12);
                $months = $months % 12;
            }
            
            return sprintf('%d tahun %d bulan', $years, $months);
        }
        
        return $paybackPeriod; // Return original if pattern doesn't match
    }

    public function saveArchive(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'items' => 'required|array|min:1',
                'items.*.item_id' => 'required|exists:items,id',
                'items.*.bandwidth_id' => 'required|exists:bandwidths,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.duration' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'capex' => 'required|numeric|min:0',
                'opex' => 'required|numeric|min:0',
                'wacc' => 'required|numeric|min:0',
                'bhp' => 'required|numeric|min:0',
                'minimal_irr' => 'required|numeric|min:0',
                'total_revenue' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:1000'
            ]);

            DB::beginTransaction();

            $capex = floatval(str_replace(['.', ','], ['', '.'], $validated['capex']));
            $opexPercentage = floatval($validated['opex']);
            $waccPercentage = floatval($validated['wacc']);
            $bhpPercentage = floatval($validated['bhp']);
            $minimalIrrPercentage = floatval($validated['minimal_irr']);
            $totalRevenue = floatval(str_replace(['.', ','], ['', '.'], $validated['total_revenue']));

            $results = $this->calculateFinancialMetrics(
                $capex,
                $totalRevenue,
                $opexPercentage,
                $bhpPercentage
            );

            $npv = $this->calculateProperNPV($results['cash_flows'], $minimalIrrPercentage / 100);
            $irr = $this->calculateProperIRR($results['cash_flows']);
            $originalPaybackPeriod = $this->calculatePaybackPeriod($results['cash_flows'], $minimalIrrPercentage);
            $paybackPeriod = $this->addMonthsToPaybackPeriod($originalPaybackPeriod, 5);

            $archive = InvestmentArchive::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'capex' => $capex,
                'opex_percentage' => $opexPercentage,
                'wacc_percentage' => $waccPercentage,
                'bhp_percentage' => $bhpPercentage,
                'minimal_irr_percentage' => $minimalIrrPercentage,
                'total_revenue' => $totalRevenue,
                'depreciation' => $results['depreciation'],
                'npv' => $npv,
                'irr' => $irr * 100,
                'payback_period' => $paybackPeriod,
                'is_viable' => ($irr * 100) >= $minimalIrrPercentage,
                'calculation_date' => now(),
                'cash_flows' => json_encode($results['cash_flows']),
                'notes' => $request->notes
            ]);

            // Save items with their relationships
            foreach ($validated['items'] as $itemData) {
                $bandwidth = Bandwidth::findOrFail($itemData['bandwidth_id']);
                $price = $bandwidth->price ?? $itemData['price'];
                
                $archive->items()->create([
                    'item_id' => $itemData['item_id'],
                    'bandwidth_id' => $itemData['bandwidth_id'],
                    'quantity' => $itemData['quantity'],
                    'duration' => $itemData['duration'],
                    'price' => $price
                ]);
            }

            DB::commit();

            Log::info('Investment archive saved successfully', [
                'archive_id' => $archive->id,
                'user_id' => Auth::id(),
                'npv' => $npv,
                'irr' => $irr * 100,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'archive' => [
                    'id' => $archive->id,
                    'npv' => $npv,
                    'irr' => $irr * 100,
                    'payback_period' => $paybackPeriod,
                    'is_viable' => ($irr * 100) >= $minimalIrrPercentage,
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error in saveArchive', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving investment archive', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getInvestmentData()
    {
        $user = Auth::user();
        $investments = InvestmentArchive::where('user_id', $user->id)->get();

        return response()->json([
            'totalRevenue' => $investments->sum('total_revenue'),
            'totalInputs' => $investments->count(),
            'totalInvestments' => $investments->count(),
            'viableProjects' => $investments->where('is_viable', true)->count(),
            'averageIRR' => $investments->avg('irr')
        ]);
    }
}