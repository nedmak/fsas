<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;
    protected $table = 'fixtures';
    protected $fillable = [
        'id',
        'ref',
        'league',
        'h_team',
        'a_team',
        'h_goals',
        'a_goals',
    ];
}
