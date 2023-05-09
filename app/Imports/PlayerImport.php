<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\admPlayer;

class PlayerImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function model(array  $row)
    {
        return new admPlayer([
            'name' => $row['name'],
            'lastname' => $row['last_name'],
            'age' => $row['age'],
            'number' => $row['number'],
            'position' => $row['position'],
            'email' => $row['email'],
            'teamID' => $this->id,
            'userID' => session()->get('email'),
        ]);
    }
}
