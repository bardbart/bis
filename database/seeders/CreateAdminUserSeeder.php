<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'lastName' => 'Admin',
            'firstName' => 'Admin',
            'middleName' => null,
            'email' => 'admin@email.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('admin'),
            'contactNo' => 9123456789,
            'houseNo' => 'Admin House No',
            'street' => 'Admin Street',
            'zipCode' => '1111',
            'province' => 'Admin District',
            'city' => 'Admin City',
            'dob' => '1999-10-9',
            'gender' => 'Male',
            'civilStatus' => 'Single',
            'citizenship' => 'Filipino',
            'remember_token' => NULL,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => NULL,
        ]);

        $timots = User::create([
            'lastName' => 'Beldeniza',
            'firstName' => 'Timothy',
            'middleName' => NULL,
            'email' => 'bsdtimothy@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
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
            'remember_token' => NULL,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => NULL,
        ]);

        $barts = User::create([
            'lastName' => 'Bartolome',
            'firstName' => 'Jon Jeremiah',
            'middleName' => 'Espina',
            'email' => 'bartolomejonjeremiah@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
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
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => NULL,
        ]);

        $baste = User::create([
            'lastName' => 'Cabiades',
            'firstName' => 'Sebastian Carlo',
            'middleName' => 'Olarte',
            'email' => 'cabiadess@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
        	'password' => bcrypt('1234'),
            'contactNo' => 9162128056,
            'houseNo' => '#29',
            'street' => 'Duhat St.',
            'zipCode' => '1772',
            'province' => 'Metro Manila',
            'city' => 'Muntinlupa City',
            'dob' => '2000-08-03',
            'gender' => 'Male',
            'civilStatus' => 'Single',
            'citizenship' => 'Filipino',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => NULL,
        ]);

        $jc = User::create([
            'lastName' => 'Amaguin',
            'firstName' => 'Juan Carlos',
            'middleName' => NULL,
            'email' => 'jaceamaguin@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
        	'password' => bcrypt('password'),
            'contactNo' => 9162128056,
            'houseNo' => '#20',
            'street' => 'Kirishima St.',
            'zipCode' => '1745',
            'province' => 'Metro Manila',
            'city' => 'Las Piñas City',
            'dob' => '1998-11-10',
            'gender' => 'Male',
            'civilStatus' => 'Single',
            'citizenship' => 'Filipino',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => NULL,
        ]);

        $jones = User::create([
            'lastName' => 'Mondejar',
            'firstName' => 'Jerry Jones',
            'middleName' => NULL,
            'email' => 'Jonesmondejar24@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
        	'password' => bcrypt('password'),
            'contactNo' => 9162128056,
            'houseNo' => '#6 San Antonio Valley 10',
            'street' => 'San Francisco St.',
            'zipCode' => '1745',
            'province' => 'Metro Manila',
            'city' => 'Parañaque City',
            'dob' => '1999-08-24',
            'gender' => 'Male',
            'civilStatus' => 'Single',
            'citizenship' => 'Filipino',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => NULL,
        ]);
  
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        $permissions = Permission::pluck('id','id')->all();
  
        // $role->syncPermissions($permissions);
   
        $admin->assignRole([$role->id]);
        $admin->syncPermissions($permissions);

        $timots->assignRole('User');
        $timots->syncPermissions(DB::table('permissions')->where('name', 'like', '%user%')->pluck('name'));

        $barts->assignRole('User');
        $barts->syncPermissions(DB::table('permissions')->where('name', 'like', '%user%')->pluck('name'));

        $baste->assignRole('User');
        $baste->syncPermissions(DB::table('permissions')->where('name', 'like', '%user%')->pluck('name'));

        $jc->assignRole('User');
        $jc->syncPermissions(DB::table('permissions')->where('name', 'like', '%user%')->pluck('name'));

        $jones->assignRole('User');
        $jones->syncPermissions(DB::table('permissions')->where('name', 'like', '%user%')->pluck('name'));

        // $user2->assignRole([$role->id]);
        // $user2->syncPermissions($permissions);
    }
}
