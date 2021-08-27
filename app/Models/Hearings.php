<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hearings extends Model
{
    use HasFactory;

    protected $fillable = [
        'compId',
        'details',
    ];
}
