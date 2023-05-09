<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerStats extends Model
{
    use HasFactory;
    protected $table = 'player_stats';
    protected $fillable = [
        'name',
        'league',
        'season',
        'app',
        'min',
        'rating',
        'sh_total',
        'sh_on_goal',
        'goals',
        'assists',
        'passes',
        'key',
        'drb_a',
        'drb_succ',
        'yellow',
        'red'
    ];
}
