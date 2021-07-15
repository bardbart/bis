<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'module-households',
            'module-services',
            'module-service-maintenances',
            'module-transactions',
            'module-barangay-officials',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
 
            'household-list',
            'household-create',
            'household-edit',
            'household-delete',
 
            'document-request-list',
            'document-request',
            'document-type-create',
            'document-delete',
            'document-edit',
 
            'complaint-list',
            'complaint-type-create',
            'complaint-edit',
            'complaint-delete',
            'complaint-file',
 
            'blotter-list',
            'blotter-edit',
            'blotter-delete',
            'blotter-file',
 
            'barangay-official-list',
            'barangay-official-create',
            'barangay-official-edit',
            'barangay-official-delete',
 
            'report-list',
            'report-print'
            
         ];

         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }
    }
}
