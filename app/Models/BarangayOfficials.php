<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayOfficials extends Model
{
    use HasFactory;

    protected $table = 'barangay_officials';

    protected $primaryKey = 'id';

<<<<<<< HEAD
    public function positions(){
        return $this->hasOne(OfficialsPositions::class);
    }
=======
    public $timestamps = 'true';

    protected $fillable = ['firstName', 'lastName', 'middleName', 'position', 'imagePath'];
    
    //use to hide certain attribute that is returned as an array
    //it is like a black list
    protected $hidden = ['updated_at'];

    //This is the opposite of the above 
    // whitelist
    protected $visible = ['firsName', 'lastName', 'middleName', 'position', 'created_at'];

>>>>>>> d487f13b6fe23a0e1fb7000c19fbde04f84986db
}
