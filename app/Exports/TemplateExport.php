<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;

class TemplateExport implements FromArray, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function array(): array
    {
        return [
            ["Name", "Last name", "Age", "Number", "Position", "Email"],
        ];
    }

    public function title(): string
    {
        return $this->name;
    }
}
