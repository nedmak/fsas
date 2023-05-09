<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Models\admTeam;

class TeamImport implements WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        $team = admTeam::get();
        $playerImports = [];

        foreach($team as $t)
        {
            $playerImports[$t->name] = new PlayerImport($t->id);
        }

        return $playerImports;
    }
}
