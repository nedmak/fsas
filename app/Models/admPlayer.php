<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admPlayer extends Model
{
    use HasFactory;
    protected $table = 'adm_players';
    protected $fillable = [
        'name',
        'lastname',
        'age',
        'number',
        'position',
        'teamID',
        'email',
        'userID',
    ];
}
