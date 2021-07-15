<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Model\ServiceMaintences;
use App\Model\Service;

class ServiceMaintenancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sm1 = ServiceMaintenances::create([
            'serviceId' => '1',
            'docType' => 'Indigency'
        ]);
        
        $sm2 = ServiceMaintenances::create([
            'serviceId' => '1',
            'docType' => 'Clearance'
        ]);

        $sm3 = ServiceMaintenances::create([
            'serviceId' => '2',
            'docType' => 'Barangay Personnel'
        ]);

        $sm4 = ServiceMaintenances::create([
            'serviceId' => '2',
            'docType' => 'Neighbor/Accused'
        ]);

        $sm5 = ServiceMaintenances::create([
            'serviceId' => '2',
            'docType' => 'Roadworks/Environment/Cleanliness'
        ]);
    }
}
