<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StatsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new SheetImport(),
            1 => new SheetImport(),
        ];
    }
}
