<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceMaintenances;
use App\Models\Services;

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
            'complainType' => 'Barangay Personnel'
        ]);

        $sm4 = ServiceMaintenances::create([
            'serviceId' => '2',
            'complainType' => 'Neighbor/Accused'
        ]);

        $sm5 = ServiceMaintenances::create([
            'serviceId' => '2',
            'complainType' => 'Roadworks/Environment/Cleanliness'
        ]);

        $sm6 = $sm5 = ServiceMaintenances::create([
            'serviceId' => '2',
            'complainType' => 'Roadworks/Environment/Cleanliness'
        ]);

        $sm6 = $sm5 = ServiceMaintenances::create([
            'serviceId' => '3',
            'complainType' => 'Report'
        ]);
    }
}
