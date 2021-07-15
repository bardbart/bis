<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailedServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'smId'
    ];

    public function services() {
        return $this->hasManyThrough();
    }
}
