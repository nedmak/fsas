<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admTeam extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'adm_teams';
    protected $fillable = [
        'name',
        'userID',
    ];
}
