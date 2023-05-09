<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admLeague extends Model
{
    use HasFactory;
    protected $table = 'adm_leagues';
    protected $fillable = [
        'name',
        'type',
        'start',
        'end',
        'userID',
    ];
}
