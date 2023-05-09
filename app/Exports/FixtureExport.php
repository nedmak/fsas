<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

//----------Models----------
use App\Models\admFixture;
use App\Models\admTeam;
//--------------------------

class FixtureExport implements WithMultipleSheets
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function sheets(): array
    {
        $sheets = [];

        $id = session()->get('fixture');
        $fixture = admFixture::where('id', $id)->get();
        $team = admTeam::get();

        foreach($fixture as $f)
        {
            $home = $f->h_team;
            $away = $f->a_team;
        }

        $pk[1] = $home;
        $pk[2] = $away;

        foreach($team as $t)
        {
            if($t->id == $home)
            {
                $hName = $t->name;
            }
            if($t->id == $away)
            {
                $aName = $t->name;
            }
        }

        $name[1] = $hName;
        $name[2] = $aName;

        for($i = 1; $i <= 2; $i++)
        {
            $sheets[] = new PlayerFixtureExport($i, $name, $pk);
        }

        return $sheets;
    }
}
