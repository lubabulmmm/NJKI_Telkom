<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\InvestmentArchive;
use App\Exports\CoverSheet;
use App\Exports\RevenueSheet;
use App\Exports\ParameterSheet;
use App\Exports\AkiCheckSheet;

class InvestmentExport implements WithMultipleSheets
{
    protected $archive;

    public function __construct(InvestmentArchive $archive)
    {
        $this->archive = $archive;
    }

    public function sheets(): array
    {
        $sheets = [
            new CoverSheet($this->archive),
            new RevenueSheet($this->archive),
            new ParameterSheet($this->archive),
            new AkiCheckSheet($this->archive)
        ];
        
        return $sheets;
    }
}

// Create separate classes for each sheet


// Similarly create RevenueSheet, ParameterSheet, and AkiCheckSheet classes