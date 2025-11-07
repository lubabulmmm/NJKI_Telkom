<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Bandwidth;
use App\Models\Calculation;
use App\Models\CalculationDetail;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalculatorController extends Controller
{
    public function getItems()
    {
        $items = Item::all();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'Tidak ada barang ditemukan'], 404);
        }

        return response()->json($items);
    }

    public function getBandwidth($itemId)
    {
        $bandwidths = Bandwidth::where('item_id', $itemId)->get();

        if ($bandwidths->isEmpty()) {
            return response()->json(['message' => 'Bandwidth tidak ditemukan untuk barang ini'], 404);
        }

        return response()->json($bandwidths);
    }

    public function calculateInvestmentMetrics(Request $request)
    {
        $request->validate([
            'revenue' => 'required|numeric',
            'capex' => 'required|numeric',
            'opex' => 'required|numeric|min:0|max:100',
            'wacc' => 'required|numeric|min:0|max:100',
            'bhp' => 'required|numeric|min:0|max:100',
            'minimal_irr' => 'required|numeric|min:0|max:100',
            'items' => 'sometimes|array',
        ]);

        // Ambil nilai dari input
        $revenue = $request->revenue;
        $capex = $request->capex;
        $opexPercentage = $request->opex;
        $wacc = $request->wacc / 100; // Konversi ke desimal
        $bhpPercentage = $request->bhp;
        $minimalIRR = $request->minimal_irr / 100; // Konversi ke desimal
        
        // Hitung nilai aktual dari persentase
        $opex = $revenue * ($opexPercentage / 100);
        $bhp = $revenue * ($bhpPercentage / 100);
        
        // Hitung depresiasi (Straight Line 3 Tahun)
        $depreciation = $capex / 3;

        // Hitung EBITDA
        $ebitda = $revenue - $opex - $bhp;

        // Hitung EBITDA Margin
        $ebitdaMargin = ($ebitda / $revenue) * 100;

        // Hitung EBIT
        $ebit = $ebitda - $depreciation;

        // Hitung Taxes (30%)
        $taxes = max(0, $ebit * 0.3);

        // Hitung NOPAT
        $nopat = $ebit - $taxes;

        // Hitung Net Cash Flow untuk 3 tahun
        $cashFlows = [
            -$capex, // Tahun 0
            $nopat + $depreciation, // Tahun 1
            $nopat + $depreciation, // Tahun 2
            $nopat + $depreciation, // Tahun 3
        ];

        // Hitung NPV menggunakan WACC
        $npv = $this->calculateNPV($cashFlows, $wacc);

        // Hitung IRR
        $irr = $this->calculateIRR($cashFlows);

        // Hitung Payback Period
        $paybackPeriod = $this->calculatePaybackPeriod($cashFlows);

        // Hitung Discounted Cash Flows
        $discountedCashFlows = [];
        for ($i = 0; $i < count($cashFlows); $i++) {
            $discountedCashFlows[$i] = $cashFlows[$i] / pow(1 + $wacc, $i);
        }

        // Hitung Cumulative Cash Flows
        $cumulativeCashFlows = [];
        $cumulativeCashFlows[0] = $cashFlows[0];
        for ($i = 1; $i < count($cashFlows); $i++) {
            $cumulativeCashFlows[$i] = $cumulativeCashFlows[$i - 1] + $cashFlows[$i];
        }

        return response()->json([
            'revenue' => $revenue,
            'capex' => $capex,
            'opex' => $opex,
            'opex_percentage' => $opexPercentage,
            'bhp' => $bhp,
            'bhp_percentage' => $bhpPercentage,
            'wacc' => $wacc * 100,
            'npv' => round($npv, 2),
            'irr' => round($irr, 2),
            'payback_period' => $paybackPeriod,
            'ebitda' => round($ebitda, 2),
            'ebitda_margin' => round($ebitdaMargin, 2),
            'depreciation' => round($depreciation, 2),
            'ebit' => round($ebit, 2),
            'taxes' => round($taxes, 2),
            'nopat' => round($nopat, 2),
            'cash_flows' => array_map(function($val) { return round($val, 2); }, $cashFlows),
            'discounted_cash_flows' => array_map(function($val) { return round($val, 2); }, $discountedCashFlows),
            'cumulative_cash_flows' => array_map(function($val) { return round($val, 2); }, $cumulativeCashFlows),
        ]);
    }

    private function calculateNPV($cashFlows, $discountRate)
    {
        $npv = 0;
        for ($i = 0; $i < count($cashFlows); $i++) {
            $npv += $cashFlows[$i] / pow(1 + $discountRate, $i);
        }
        return $npv;
    }

    private function calculateIRR($cashFlows)
    {
        // Cek apakah ada kemungkinan IRR (minimal harus ada cash flow positif dan negatif)
        $hasPositive = false;
        $hasNegative = false;
        foreach ($cashFlows as $cf) {
            if ($cf > 0) $hasPositive = true;
            if ($cf < 0) $hasNegative = true;
        }
        
        if (!$hasPositive || !$hasNegative) {
            return 0; // Tidak ada IRR yang valid
        }
        
        // Metode Newton-Raphson untuk menghitung IRR
        $guess = 0.1; // Initial guess
        $tolerance = 0.0001;
        $maxIterations = 100;
        
        for ($i = 0; $i < $maxIterations; $i++) {
            $npv = $this->calculateNPV($cashFlows, $guess);
            $derivative = $this->calculateNPVDerivative($cashFlows, $guess);
            
            // Hindari pembagian dengan nol
            if (abs($derivative) < 0.0000001) {
                break;
            }
            
            $newGuess = $guess - $npv / $derivative;
            
            // Cek konvergensi
            if (abs($newGuess - $guess) < $tolerance) {
                $guess = $newGuess;
                break;
            }
            
            $guess = $newGuess;
            
            // Batasi nilai IRR antara -0.999 dan 100
            if ($guess <= -0.999 || $guess > 100) {
                return 0; // IRR di luar jangkauan yang masuk akal
            }
        }
        
        return $guess * 100; // Convert to percentage
    }

    private function calculateNPVDerivative($cashFlows, $rate)
    {
        $derivative = 0;
        for ($i = 1; $i < count($cashFlows); $i++) {
            $derivative -= $i * $cashFlows[$i] / pow(1 + $rate, $i + 1);
        }
        return $derivative;
    }

    private function calculatePaybackPeriod($cashFlows)
    {
        $cumulativeCF = 0;
        $periods = count($cashFlows);
        $paybackPeriod = 0;
        
        // Handle kasus khusus
        if ($cashFlows[0] >= 0) {
            return "0 tahun 0 bulan"; // Kasus langsung balik modal pada tahun 0
        }
        
        for ($i = 0; $i < $periods; $i++) {
            $prevCumulativeCF = $cumulativeCF;
            $cumulativeCF += $cashFlows[$i];
            
            // Jika kita melewati titik balik modal di periode ini
            if ($i > 0 && $prevCumulativeCF < 0 && $cumulativeCF >= 0) {
                // Hitung bagian periode yang tepat
                $fraction = abs($prevCumulativeCF) / abs($cashFlows[$i]);
                $paybackPeriod = ($i - 1) + $fraction;
                break;
            }
            // Jika tepat pada akhir periode
            else if ($cumulativeCF == 0) {
                $paybackPeriod = $i;
                break;
            }
        }
        
        // Jika cash flow kumulatif tidak pernah positif
        if ($cumulativeCF < 0) {
            return "Tidak Terdefinisi";
        }
        
        // Format hasil
        $years = floor($paybackPeriod);
        $months = round(($paybackPeriod - $years) * 12);
        
        return "$years tahun $months bulan";
    }

    public function saveCalculation(Request $request)
    {
        $request->validate([
            'revenue' => 'required|numeric',
            'capex' => 'required|numeric',
            'opex' => 'required|numeric|min:0|max:100',
            'wacc' => 'required|numeric|min:0|max:100',
            'bhp' => 'required|numeric|min:0|max:100',
            'minimal_irr' => 'required|numeric|min:0|max:100',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.bandwidth_id' => 'required|exists:bandwidths,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);
        
        // Hitung investasi untuk memastikan nilai yang digunakan sama
        $calculationResult = $this->calculateInvestmentMetrics($request);
        $calculationData = json_decode($calculationResult->getContent(), true);
        
        DB::beginTransaction();
        try {
            // Simpan data kalkulasi utama
            $calculation = new Calculation();
            $calculation->revenue = $request->revenue;
            $calculation->capex = $request->capex;
            $calculation->opex_percentage = $request->opex;
            $calculation->wacc = $request->wacc;
            $calculation->bhp_percentage = $request->bhp;
            $calculation->minimal_irr = $request->minimal_irr;
            $calculation->npv = $calculationData['npv'];
            $calculation->irr = $calculationData['irr'];
            $calculation->payback_period = $calculationData['payback_period'];
            $calculation->save();
            
            // Simpan detail items
            foreach ($request->items as $item) {
                $detail = new CalculationDetail();
                $detail->calculation_id = $calculation->id;
                $detail->item_id = $item['item_id'];
                $detail->bandwidth_id = $item['bandwidth_id'];
                $detail->quantity = $item['quantity'];
                $detail->price = $item['price'];
                $detail->subtotal = $item['quantity'] * $item['price'];
                $detail->save();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Kalkulasi berhasil disimpan',
                'calculation_id' => $calculation->id,
                'calculation' => $calculationData
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan kalkulasi: ' . $e->getMessage()
            ], 500);
        }
    }

    // In CalculatorController
public function getItemsApi()
{
    $items = Item::all();
    return response()->json($items);
}

public function getBandwidthApi($itemId)
{
    $bandwidths = Bandwidth::where('item_id', $itemId)->get();
    return response()->json($bandwidths);
}

public function saveArchive(Request $request)
{
    $request->validate([
        'bandwidth_id' => 'required|exists:bandwidths,id',
        'capex' => 'required|numeric',
        'opex' => 'required|numeric',
        'wacc' => 'required|numeric',
        'bhp' => 'required|numeric',
        'minimal_irr' => 'required|numeric',
        'depreciation' => 'required|numeric',
    ]);

    // Perform calculations (similar to your existing calculateInvestmentMetrics)
    $result = $this->calculateInvestmentMetrics($request);

    // Save to archive table
    $archive = Archive::create([
        'bandwidth_id' => $request->bandwidth_id,
        'capex' => $request->capex,
        'opex' => $request->opex,
        'wacc' => $request->wacc,
        'bhp' => $request->bhp,
        'minimal_irr' => $request->minimal_irr,
        'depreciation' => $request->depreciation,
        'npv' => $result['npv'],
        'irr' => $result['irr'],
        'payback_period' => $result['payback_period'],
        'user_id' => auth()->id()
    ]);

    return response()->json([
        'success' => true,
        'npv' => $result['npv'],
        'irr' => $result['irr'],
        'payback_period' => $result['payback_period']
    ]);
}
}