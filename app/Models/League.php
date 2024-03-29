<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;
    protected $table = 'leagues';
    protected $fillable = [
        'name',
        'type',
        'country',
        'season',
        'start',
        'end',
    ];
}
