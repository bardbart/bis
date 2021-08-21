<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlottersTransactions extends Model
{
    use HasFactory;

    protected $fillable = ['transId', 'blotType', 'blotDetails', 'respondents', 'respondentsAdd', 'reason'];
}
