<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsTransactions extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = [
        'transId',
        'dmId',
        'purpose',
        'barangayIdPath',
        'reason',
    ];
}
