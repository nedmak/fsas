<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamStats extends Model
{
    use HasFactory;
    protected $table = 'team_stats';
    protected $fillable = [
        'season',
        'league',
        'form',
        'played',
        'wins',
        'ties',
        'loses',
        'goals',
        'goals_against',
        'clean_sheets',
        'yellow_cards',
        'red_cards',
        'team'
    ];
}
