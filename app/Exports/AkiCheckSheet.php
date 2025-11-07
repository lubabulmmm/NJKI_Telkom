<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AkiCheckSheet implements FromArray, WithTitle, WithStyles
{
    protected $archive;

    public function __construct($archive)
    {
        $this->archive = $archive;
    }

    public function array(): array
    {
        // Ambil input utama
        $capex = $this->archive->capex;
        $totalRevenue = $this->archive->total_revenue;
        $opexPercentage = $this->archive->opex_percentage;
        $bhpPercentage = $this->archive->bhp_percentage;
        $minimalIrr = $this->archive->minimal_irr_percentage / 100;

        // Konversi ke juta untuk tampilan
        $capexJuta = $capex / 1000000;
        $revenueJuta = $totalRevenue / 1000000;

        // OPEX dihitung dari persentase CAPEX
        $opex = ($opexPercentage / 100) * $capex;
        $opexJuta = $opex / 1000000;

        // BHP dihitung dari persentase revenue
        $bhp = ($bhpPercentage / 100) * $totalRevenue;
        $bhpJuta = $bhp / 1000000;

        // Depresiasi (3 tahun)
        $depreciation = $capex / 3;
        $depreciationJuta = $depreciation / 1000000;

        // Perhitungan per tahun (1-3)
        $cashFlows = [-$capex];
        $rows = [
            'revenue' => ['', $revenueJuta, $revenueJuta, $revenueJuta],
            'opex' => ['0', $opexJuta, $opexJuta, $opexJuta],
            'bhp' => ['0', $bhpJuta, $bhpJuta, $bhpJuta],
            'depreciation' => ['0', $depreciationJuta, $depreciationJuta, $depreciationJuta],
            'ebitda' => [],
            'ebit' => [],
            'tax' => [],
            'nopat' => [],
            'netcashflow' => [],
        ];

        for ($year = 1; $year <= 3; $year++) {
            // EBITDA = Revenue - OPEX - BHP
            $ebitda = $totalRevenue - $opex - $bhp;
            $ebitdaJuta = $ebitda / 1000000;
            $rows['ebitda'][] = $ebitdaJuta;

            // EBIT = EBITDA - Depresiasi
            $ebit = $ebitda - $depreciation;
            $ebitJuta = $ebit / 1000000;
            $rows['ebit'][] = $ebitJuta;

            // Pajak = 30% dari EBIT (jika positif)
            $tax = $ebit > 0 ? $ebit * 0.3 : 0;
            $taxJuta = $tax / 1000000;
            $rows['tax'][] = $taxJuta;

            // NOPAT = EBIT - Pajak
            $nopat = $ebit - $tax;
            $nopatJuta = $nopat / 1000000;
            $rows['nopat'][] = $nopatJuta;

            // Net Cash Flow = NOPAT + Depresiasi
            $netCashFlow = $nopat + $depreciation;
            $netCashFlowJuta = $netCashFlow / 1000000;
            $rows['netcashflow'][] = $netCashFlowJuta;

            $cashFlows[] = $netCashFlow;
        }

        // Discounted Net Cash Flow (NPV dengan minimal IRR)
        $dcf = [
            0 => -$capexJuta,
            1 => $rows['netcashflow'][0] / pow(1 + $minimalIrr, 1),
            2 => $rows['netcashflow'][1] / pow(1 + $minimalIrr, 2),
            3 => $rows['netcashflow'][2] / pow(1 + $minimalIrr, 3),
        ];

        // Cumulative Discounted Cash Flow
        $ccf = [
            0 => -$capexJuta,
            1 => -$capexJuta + $dcf[1],
            2 => -$capexJuta + $dcf[1] + $dcf[2],
            3 => -$capexJuta + $dcf[1] + $dcf[2] + $dcf[3],
        ];

        // EBITDA Margin
        $ebitda_margin = $totalRevenue > 0 ? round($ebitda / $totalRevenue * 100) : 0;

        return [
            ['ANALISA KELAYAKAN INVESTASI (AKI) - dalam Juta'],
            ['Tahun ke', '0', '1', '2', '3'],
            ['Revenue', ...$rows['revenue']],
            ['OPEX', ...$rows['opex']],
            ['BHP', ...$rows['bhp']],
            ['EBITDA', '0', ...$rows['ebitda']],
            ['EBITDA Margin', '0%', $ebitda_margin.'%', $ebitda_margin.'%', $ebitda_margin.'%'],
            ['Depreciation', ...$rows['depreciation']],
            ['EBIT', '0', ...$rows['ebit']],
            ['Taxes (30%)', '0', ...$rows['tax']],
            ['NOPAT (EBIT - Tax)', '0', ...$rows['nopat']],
            ['Net Cash flow', $dcf[0], ...$rows['netcashflow']],
            ['Discounted Net Cash flow', $dcf[0], $dcf[1], $dcf[2], $dcf[3]],
            ['Cumulative Discounted Cash Flow', $ccf[0], $ccf[1], $ccf[2], $ccf[3]],
            [''],
            ['Minimal IRR', $this->archive->minimal_irr_percentage . '%'],
            ['NPV', intval(round($ccf[3]))], // <-- pastikan ini bulat, bukan persen
            ['IRR', number_format($this->archive->irr * 100, 2) . '%', '', $this->archive->is_viable ? 'Layak' : 'Tidak Layak'],
            ['Payback Period', $this->archive->payback_period ?? 2, '', 'tahun'],
            [''],
            ['Note:']
        ];
    }

    public function title(): string
    {
        return 'AKI_CHECK';
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        // Title style - purple background with white text
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '800080']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Format percentages
        $percentageCells = ['B6:E6', 'B17', 'B19'];
        foreach ($percentageCells as $range) {
            $sheet->getStyle($range)->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);
        }

        // Format numbers with thousands separator and 2 decimals
        $numberCells = ['B3:E5', 'B7:E15', 'B18'];
        foreach ($numberCells as $range) {
            $sheet->getStyle($range)->getNumberFormat()
                ->setFormatCode('#,##0.00');
        }

        // Highlight negative values in red
        $negativeStyle = [
            'font' => ['color' => ['rgb' => 'FF0000']]
        ];
        
        // Apply red color to negative values
        foreach ($sheet->getRowIterator(3, 15) as $row) {
            foreach ($row->getCellIterator('B', 'E') as $cell) {
                if (is_numeric($cell->getValue()) && $cell->getValue() < 0) {
                    $sheet->getStyle($cell->getCoordinate())->applyFromArray($negativeStyle);
                }
            }
        }

        // Add status color for Layak/Tidak Layak
        $sheet->getStyle('D19')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $this->archive->is_viable ? '92D050' : 'FF0000']
            ]
        ]);

        // Add borders
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A2:E15')->applyFromArray($borderStyle);
        $sheet->getStyle('A17:D21')->applyFromArray($borderStyle);
        
        // Align text
        $sheet->getStyle('A2:A15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B2:E15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A17:A21')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B17:D21')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Set row height
        foreach (range(1, 23) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        return [];
    }
}