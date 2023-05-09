<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\admPlayerStas;

class SheetImport implements ToModel, WithHeadingRow
{
    public function model(array  $row)
    {
        return new admPlayerStas([
            'name' => $row['name'],
            'lastname' => $row['last_name'],
            'min' => $row['minutes'],
            'shots' => $row['shots'],
            'shots_on_goal' => $row['shots_on_goal'],
            'goals' => $row['goals'],
            'assists' => $row['assists'],
            'yellow' => $row['yellow_cards'],
            'red' => $row['red_cards'],
            'teamID' => $row['team_id'],
            'fixtureID' => session()->get('fixture'),
            'userID' => session()->get('email'),
        ]);
    }
}
