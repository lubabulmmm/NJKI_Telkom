<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RevenueSheet implements FromArray, WithTitle, WithStyles
{
    protected $archive;

    public function __construct($archive)
    {
        $this->archive = $archive;
    }

    public function array(): array
    {
        // Header rows
        $rows = [
            ['BREAKDOWN REVENUE PROJECTION'],
            [''],
            [''],
            [''],
            ['NO', 'STREAM PORTFOLIO', 'PRODUCTS', 'CUSTOMER NAME', 'CUST GROUP', 'QUANTITY', 'DURATION', 'BANDWIDTH', 'PRICE/UNIT', 'TOTAL', '', '', '', '', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '(Unit)', '(Month)', '(Mbps)', '(Rp)', '(Rp)', '', '', '', '', '', '', '', '', '', '', ''],
            [''],
        ];

        // Get items from the archive with relationships
        $items = $this->archive->items()->with(['item', 'bandwidth'])->get();
        $totalRevenue = 0;
        $itemCount = 1;

        if ($items->isNotEmpty()) {
            foreach ($items as $item) {
                // Calculate revenue for this item
                $totalPrice = $item->price * $item->quantity * $item->duration;
                $totalRevenue += $totalPrice;

                // Add item row with actual data from calculator
                $rows[] = [
                    $itemCount,                                    // NO
                    'Internet Service',                           // STREAM PORTFOLIO
                    $item->item->nama_barang ?? '-',             // PRODUCTS 
                    'Customer',                                   // CUSTOMER NAME
                    'TELKOM',                                     // CUST GROUP
                    number_format($item->quantity, 0),            // QUANTITY
                    number_format($item->duration, 0),            // DURATION
                    $item->bandwidth->bw ?? '-',                 // BANDWIDTH
                    number_format($item->price, 0, ',', '.'),    // PRICE/UNIT (from calculator)
                    number_format($totalPrice, 0, ',', '.'),     // TOTAL
                    '', '', '', '', '', '', '', '', '', '', ''   // Empty columns
                ];

                $itemCount++;
            }
        } else {
            // Jika tidak ada items, tampilkan data dari archive
            $totalRevenue = $this->archive->total_revenue;
            $rows[] = [
                '1',                                              // NO
                'Internet Service',                               // STREAM PORTFOLIO
                '-',                                              // PRODUCTS
                'Customer',                                       // CUSTOMER NAME
                'TELKOM',                                         // CUST GROUP
                '-',                                              // QUANTITY
                '-',                                              // DURATION
                '-',                                              // BANDWIDTH
                '-',                                              // PRICE/UNIT
                number_format($totalRevenue, 0, ',', '.'),       // TOTAL
                '', '', '', '', '', '', '', '', '', '', ''       // Empty columns
            ];
        }

        // Add empty row before totals
        $rows[] = array_fill(0, 21, '');

        // Add total row
        $rows[] = [
            '',                                             
            '',                                             
            'TOTAL REVENUE',                                
            '',                                             
            '',                                             
            '',                                             
            '',                                             
            '',                                             
            '',                                             
            number_format($totalRevenue, 0, ',', '.'),     
            '', '', '', '', '', '', '', '', '', '', ''     
        ];

        // Add assumptions section with actual WACC
        $rows = array_merge($rows, [
            array_fill(0, 21, ''),  // Empty row
            ['ASSUMPTIONS'] + array_fill(1, 20, ''),
            ['1', 'MACRO-ECONOMICS ASSUMPTIONS (DO NOT CHANGE)'] + array_fill(2, 19, ''),
            array_fill(0, 21, ''),
            ['Local Currency (LC) Spot Interest Rate1', '', '', '', '', ($this->archive->wacc_percentage ?? 0).'%'] + array_fill(6, 15, ''),
            ['USD Spot Interest Rate1', '', '', '', '', '0.005'] + array_fill(6, 15, ''),
            ['USD/LC Rate', '', '', '', '', '14569.66'] + array_fill(6, 15, ''),
            ['Inflation', '', '', '', '', '0.03346'] + array_fill(6, 15, ''),
            ['Assumed Tax Rate', '', '', '', '', '0.25'] + array_fill(6, 15, '')
        ]);

        return $rows;
    }

    public function title(): string
    {
        return 'REVENUE';
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);      // NO
        $sheet->getColumnDimension('B')->setWidth(20);     // STREAM PORTFOLIO
        $sheet->getColumnDimension('C')->setWidth(25);     // PRODUCTS
        $sheet->getColumnDimension('D')->setWidth(15);     // CUSTOMER NAME
        $sheet->getColumnDimension('E')->setWidth(15);     // CUST GROUP
        $sheet->getColumnDimension('F')->setWidth(12);     // QUANTITY
        $sheet->getColumnDimension('G')->setWidth(12);     // DURATION
        $sheet->getColumnDimension('H')->setWidth(12);     // BANDWIDTH
        $sheet->getColumnDimension('I')->setWidth(20);     // PRICE/UNIT
        $sheet->getColumnDimension('J')->setWidth(20);     // TOTAL

        // Title style
        $sheet->mergeCells('A1:U1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9']
            ]
        ]);

        // Header style
        $sheet->getStyle('A5:J6')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        // Data rows style
        $lastRow = 7 + (count($this->archive->items ?? []) + 2); // +2 for empty row and total
        $sheet->getStyle('A7:J'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        // Align numbers to right
        $sheet->getStyle('F7:J'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Format numbers
        $sheet->getStyle('I7:J'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');

        // Total row style
        $totalRow = $lastRow;
        $sheet->getStyle('A'.$totalRow.':J'.$totalRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
            ]
        ]);

        // Assumptions section
        $assumptionsStart = $totalRow + 2;
        $sheet->getStyle('A'.$assumptionsStart)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2EFDA']
            ]
        ]);

        // Format percentage values in assumptions
        $sheet->getStyle('F'.($assumptionsStart + 3).':F'.($assumptionsStart + 7))
            ->getNumberFormat()
            ->setFormatCode('0.00000');

        return [];
    }
}