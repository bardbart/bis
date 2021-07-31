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
            //admin only
            'user-barangay-official-list',
            'barangay-official-create',
            'barangay-official-edit',
            'barangay-official-delete',
 
            
            'documents-show-ID',
            'documents-process',
            'documents-view',
            'documents-save-PDF',
            'documents-disapprove',
            
            'complaint-show-details',
            'complaint-settle',
            'complaint-view-settle-form',
            'complaint-save-settle-form',
            'complaint-escalate',
            'complaint-view-complaint-form',
            'complaint-save-complaint-form',
            'complaint-view-escalation-form',
            'complaint-save-escalation-form',
            'complaint-reject',
            
            'blotter-note',
            'blotter-show',
            
            'usrmngmnt-show',
            'usrmngmnt-edit',
            'usrmngmnt-delete',

            //Modules/pages

            'user-module-request-document',
            'user-module-file-complaint',
            'user-module-file-blotter',

            'module-service-management',
            
            'module-requested-documents',
            'module-filed-complaints',
            'module-filed-blotters',
            
            'module-usrmngmnt',

            'module-reports',

        ];

         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }
    }
}
