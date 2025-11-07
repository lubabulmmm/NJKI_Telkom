<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ParameterSheet implements FromArray, WithTitle, WithStyles
{
    protected $archive;

    public function __construct($archive)
    {
        $this->archive = $archive;
    }

    public function array(): array
    {
        $capex = $this->archive->capex ?? 598334340;
        $totalRevenue = $this->archive->total_revenue ?? 600000000;
        $growthRevenue = 0.0; // Jika ada growth, ambil dari archive
        $opexPercentage = $this->archive->opex_percentage ?? 12;
        $ebitdaMargin = ''; // Jika ingin dihitung, bisa dari hasil perhitungan
        $wacc = $this->archive->wacc_percentage ?? 11.49;
        $depreciation = $capex / 3;
        $minimalIrr = $this->archive->minimal_irr_percentage ?? 13.49;
        $bhpPercentage = $this->archive->bhp_percentage ?? 20;

        // OPEX per tahun
        $opexNominal = $capex * ($opexPercentage / 100);
        // BHP per tahun
        $bhpNominal = $totalRevenue * ($bhpPercentage / 100);

        return [
            ['Parameter dan Asumsi'],
            ['KEGIATAN INVESTASI : HEM BGES TREG-5'],
            [''],
            ['CAPEX', $capex],
            ['Revenue', $totalRevenue],
            ['Growth Revenue', number_format($growthRevenue, 1, ',', '') . '%', 'sesuai tabel perhitungan rev'],
            ['Expenses/OPEX', number_format($opexPercentage, 2, ',', '') . '%', $opexPercentage . '% dari nilai aset berjalan (sitac/change/marketing/sewa)'],
            ['Ebitda Margin', $ebitdaMargin, 'min 19,8%'],
            ['WACC', number_format($wacc, 2, ',', '') . '%', 'merujuk pada Juksun 2022'],
            ['Depretiation', number_format($depreciation, 0, ',', ''), 'Straight Line dalam 3 tahun'],
            ['Minimal IRR', number_format($minimalIrr, 2, ',', '') . '%'],
            ['BHP, Marketing, BUA, SDM', number_format($bhpPercentage, 2, ',', '') . '%', 'dari revenue/tahun (hasil benchmark treg lain)'],
            [''],
            ['EXPENSES'],
            ['TAHUN INVESTASI', '-', '1', '2', '3'],
            ['Nilai ASSET', '', number_format($capex, 0, ',', ''), number_format($capex * 2/3, 0, ',', ''), number_format($capex * 1/3, 0, ',', '')],
            ['O & M (include QE)', '', number_format($opexNominal, 0, ',', ''), number_format($opexNominal, 0, ',', ''), number_format($opexNominal, 0, ',', '')],
            ['BHP, Marketing, BUA, SDM', '', number_format($bhpNominal, 0, ',', ''), number_format($bhpNominal, 0, ',', ''), number_format($bhpNominal, 0, ',', '')],
            [''],
            ['Total Biaya Opex', '', number_format($opexNominal + $bhpNominal, 0, ',', ''), number_format($opexNominal + $bhpNominal, 0, ',', ''), number_format($opexNominal + $bhpNominal, 0, ',', '')]
        ];
    }

    public function title(): string
    {
        return 'PARAMETER dan ASUMSI';
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);

        // Title style
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A1:A2')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ]);

        // Parameters section style
        $paramStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFFFF00']
            ]
        ];
        $sheet->getStyle('B7:B8')->applyFromArray($paramStyle);
        $sheet->getStyle('B10:B12')->applyFromArray($paramStyle);

        // Format percentages
        $percentageCells = ['B6:B7', 'B9:B10', 'B12'];
        foreach ($percentageCells as $cell) {
            $sheet->getStyle($cell)->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);
        }

        // Format currency values
        $currencyCells = [
            'B4:B5',  // CAPEX and Revenue
            'B10',    // Depreciation
            'C16:E16', // Asset values
            'C17:E18', // O&M and BHP costs
            'C20:E20'  // Total OPEX
        ];
        foreach ($currencyCells as $range) {
            $sheet->getStyle($range)->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        // Expenses section header
        $sheet->getStyle('A14')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9']
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
        $sheet->getStyle('A15:E20')->applyFromArray($borderStyle);

        // Align text
        $sheet->getStyle('A4:A12')->getAlignment()->setIndent(1);
        $sheet->getStyle('B4:E20')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }
}