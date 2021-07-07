<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transMode',
        'purpose',
        'paymentMode',
        'complaintDetails',
        'respondents',
        'respondentsAdd',
        'blotterDetails',
        'barangayIdPath',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'availedServiceId'
    ];

    public function users() {
        return $this->hasManyThrough(
            User::class,
            AvailedServices::class
        );
    }

}
