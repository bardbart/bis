<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayOfficials extends Model
{
    use HasFactory;

    protected $table = 'barangay_officials';

    protected $primaryKey = 'id';

    public $timestamps = 'true';

    protected $fillable = ['firstName', 'lastName', 'middleName', 'description', 'imagePath'];
    
    //use to hide certain attribute that is returned as an array
    //it is like a black list
    protected $hidden = ['updated_at'];

    //This is the opposite of the above 
    // whitelist
    protected $visible = ['firsName', 'lastName', 'middleName', 'description', 'created_at'];

    public function position()
    {
        return $this->hasOne(OfficialsPositions::class);
    }
}
