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
            'dob' => '2000-08-03',
            'gender' => 'Male',
            'civilStatus' => 'Single',
            'citizenship' => 'Filipino',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => NULL,
        ]);
  
        $role = Role::create(['name' => 'Admin']);

        Role::create(['name' => 'Resident']);
        Role::create(['name' => 'Clerk']);
        Role::create(['name' => 'Councilor']);
        Role::create(['name' => 'Secretary']);
        Role::create(['name' => 'Chairman']);

        $permissions = Permission::pluck('id','id')->all();
  
        // $role->syncPermissions($permissions);
   
        $admin->assignRole([$role->id]);
        $admin->syncPermissions($permissions);

        $timots->assignRole('Resident');
        $timots->syncPermissions(DB::table('permissions')->where('name', 'like', '%res%')->pluck('name'));

        $barts->assignRole('Resident');
        $barts->syncPermissions(DB::table('permissions')->where('name', 'like', '%res%')->pluck('name'));

        $baste->assignRole('Resident');
        $baste->syncPermissions(DB::table('permissions')->where('name', 'like', '%res%')->pluck('name'));
    }
}
