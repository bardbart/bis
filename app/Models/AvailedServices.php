<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailedServices extends Model
{
    use HasFactory;

    public function services() {
        return $this->hasManyThrough();
    }
}
