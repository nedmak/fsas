<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admFixture extends Model
{
    use HasFactory;
    protected $table = 'adm_fixtures';
    protected $fillable = [
        'date',
        'h_team',
        'a_team',
        'userID',
    ];
}
