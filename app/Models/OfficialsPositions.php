<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialsPositions extends Model
{
    use HasFactory;

    protected $table = 'officials_positions';
    protected $primaryKey = 'id';

    public function barangayOfficial()
    {
        return $this->belongsTo(BarangayOfficials::class);
    }
}
