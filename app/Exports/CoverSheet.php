<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CoverSheet implements FromArray, WithTitle, WithStyles
{
    protected $archive;

    public function __construct($archive)
    {
        $this->archive = $archive;
    }

    public function array(): array
    {
        // Parse the payback period string
        $paybackPeriod = $this->archive->payback_period ?? '';
        preg_match('/(\d+) tahun (\d+) bulan|(\d+) bulan/', $paybackPeriod, $matches);
        
        $years = !empty($matches[1]) ? $matches[1] : '0';
        $months = !empty($matches[2]) ? $matches[2] : (!empty($matches[3]) ? $matches[3] : '0');

        return [
            ['HASIL EVALUASI AKI CAPEX PT. TELKOM TAHUN 2024'],
            [''],
            ['USULAN PROGRAM PP'],
            ['Nama Program', ':', '', ''],  // Kosong untuk diisi manual
            ['Jumlah LOP', ':', '', ''],   // Kosong untuk diisi manual
            ['Kapasitas', 'VOLUME', ':', ''],  // Kosong untuk diisi manual
            ['', 'SATUAN', ':', 'PORT'],
            ['Nilai Program', 'CAPEX', ':', number_format($this->archive->capex ?? 598334340, 0, ',', '.')],
            ['', 'BOP LAKWAS', ':', 'Rp'],
            ['Capex / Line', '', ':', 'Rp ' . number_format($this->archive->capex / ($this->archive->lop_count ?? 1), 0, ',', '.')],
            ['Waktu Penyelesaian', 'bulan', ':', ''],  // Kosong untuk diisi manual
            ['Rencana Selesai', '', ':', ''],
            ['Rencana Pemakaian A/pro', 'tahun', ':', ''],  // Kosong untuk diisi manual
            ['(Lama Kontrak / Stay of length pelanggan)', '', '', ''],
            ['Pemilihan Teknologi', '', ':', 'FO'],
            ['Usulan pola kemitraan', '', ':', ''],
            ['Alasan keberadaan proyek', '', ':', ''],
            [''],
            ['Kinerja Bisnis sampai tahun ke - 3', 'IRR', ':', number_format(($this->archive->irr ?? 0.1872) * 100, 2) . '%'],
            ['', 'NPV', ':', 'Rp ' . number_format($this->archive->npv ?? 53517395, 0, ',', '.')],
            ['', 'BEP (TAHUN)', ':', $years],
            ['', '(Bulan)', ':', $months],
            ['', 'BCR', ':', ''],
            ['', 'CAGR', ':', ''],
            ['', 'Discount rate', ':', ''],
            ['', 'Loss Rev/bln', ':', ''],
            [''],
            ['KRITERIA INVESTASI UNTUK PERIODE PEMAKAIAN', '', ':', $this->archive->is_viable ? 'LAYAK' : 'TIDAK LAYAK'],
            [''],
            ['Catatan penting', '', ':', $this->archive->notes ?? 'Tidak ada note/catatan'],  // Modified line
            [''],
            [''],
            ['NAMA / NIK / JABATAN', '', '', 'TANGGAL / TTD'],
            ['DIBUAT OLEH', '', '', ''],
            [''],
            [''],
            ['DIPERIKSA OLEH', '', '', ''],
            [''],
            ['']
        ];
    }

    public function title(): string
    {
        return 'COVER';
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(5);
        $sheet->getColumnDimension('D')->setWidth(35);

        // Title style
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00']
            ]
        ]);

        // Section headers style
        $sectionStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9']
            ]
        ];
        $sheet->getStyle('A3')->applyFromArray($sectionStyle);

        // Format business performance section
        $sheet->getStyle('A19:D24')->applyFromArray([
            'font' => ['bold' => true]
        ]);

        // Format investment criteria
        $criteriaCell = 'D28';
        $isLayak = $this->archive->is_viable ?? false;
        $sheet->getStyle($criteriaCell)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $isLayak ? '00FF00' : 'FF0000']
            ]
        ]);
        $sheet->getStyle('A26')->getFont()->setBold(true);

        // Add borders
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A3:D37')->applyFromArray($borderStyle);

        // Center alignment for specific cells
        $sheet->getStyle('A31:D37')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Number formatting
        $sheet->getStyle('D8')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D10')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D20')->getNumberFormat()->setFormatCode('#,##0');

        return [];
    }
}