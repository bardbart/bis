<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'lastName' => 'Beldeniza',
            'firstName' => 'Timothy',
            'middleName' => null,
            'email' => 'bsdtimothy@gmail.com',
        	'password' => bcrypt('123456'),
            'contactNo' => 9302990870,
            'houseNo' => 'Blk 31 Lot 1 Purok 4 Central Bicutan Taguig City',
            'street' => 'Poolan',
            'zipCode' => '1633',
            'province' => 'NCR District 4',
            'city' => 'Taguig City',
            'dob' => '1999-10-9',
            'gender' => 'Male',
            'civilStatus' => 'Single',
            'citizenship' => 'Filipino',
        ]);
  
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        $permissions = Permission::pluck('id','id')->all();
  
        // $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
        $user->syncPermissions($permissions);
    }
}
