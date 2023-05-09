<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

//----------------- Models ---------------------
use App\Models\admTeam;
use App\Models\admPlayer;
use App\Models\admFixture;
//----------------------------------------------

class PlayerFixtureExport implements FromQuery, ShouldAutoSize, WithTitle, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    public function __construct($number, $names, $pk)
    {
        $this->number = $number;
        $this->names = $names;
        $this->pk = $pk;
    }

    public function headings(): array
    {
        return [
            ["Team id", "Name", "Last name", "Minutes", "Shots", "Shots on goal", "Goals", "Assists", "Yellow cards", "Red cards"],
        ];
    }

    public function query()
    {
        return admPlayer::select("teamID", "name", "lastname")->where('teamID', $this->pk[$this->number]);
    }

    public function title(): string
    {
        return $this->names[$this->number];
    }
}
