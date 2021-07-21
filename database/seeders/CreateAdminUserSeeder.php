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
        	'password' => bcrypt('password'),
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

        $user2 = User::create([
            'lastName' => 'Bartolome',
            'firstName' => 'Jon Jeremiah',
            'middleName' => 'Espina',
            'email' => 'bartolomejonjeremiah@gmail.com',
        	'password' => bcrypt('password'),
            'contactNo' => 9760014639,
            'houseNo' => 'Unit 322 Bldg A6 Urban Deca Homes',
            'street' => 'McArthur Hwy',
            'zipCode' => '3019',
            'province' => 'Bulacan',
            'city' => 'Marilao City',
            'dob' => '1999-11-14',
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

        $user2->assignRole([$role->id]);
        $user2->syncPermissions($permissions);
    }
}
