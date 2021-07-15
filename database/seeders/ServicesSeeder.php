<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Services;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Document',
            'Complaint',
            'Blotter'
        ];

        foreach($services as $service)
            Services::create(['serviceName' => $service]);
    }
}
