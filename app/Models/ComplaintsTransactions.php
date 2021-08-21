<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintsTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'transId',
        'compType',
        'compDetails',
        'respondents',
        'respondentsAdd',
        'reason',
    ];
}
