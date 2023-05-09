<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admPlayerStas extends Model
{
    use HasFactory;
    protected $table = 'adm_player_stas';
    protected $fillable = [
        'name',
        'lastname',
        'min',
        'shots',
        'shots_on_goal',
        'goals',
        'assists',
        'yellow',
        'red',
        'fixtureID',
        'teamID',
        'userID',
    ];
}
