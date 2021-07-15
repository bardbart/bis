<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayOfficials extends Model
{
    use HasFactory;

    protected $table = 'barangay_officials';

    protected $primaryKey = 'id';

    public function positions(){
        return $this->hasOne(OfficialsPositions::class);
    }
}
