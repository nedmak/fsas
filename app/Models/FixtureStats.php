<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixtureStats extends Model
{
    use HasFactory;
    protected $table = 'fixture_stats';
    protected $fillable = [
        'id',
        'team',
        'sh_on_goal',
        'sh_off_goal',
        'sh_total',
        'sh_bloked',
        'sh_in_box',
        'sh_out_box',
        'fouls',
        'corners',
        'offsides',
        'ball_possession',
        'yellow',
        'red',
        'saves',
        'passes',
        'acc_passes',
        'pass_proc',
        'fk',
    ];
}
