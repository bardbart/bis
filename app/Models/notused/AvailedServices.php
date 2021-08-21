<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvailedServices extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'userId',
        'smId'
    ];

    // public function services() {
    //     return $this->hasManyThrough();
    // }

    public function services()
    {
        return $this->belongsTo(Transaction::class);
    }
}
