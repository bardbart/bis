<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentTypes;


class DocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = 
        [
            'Indigency',
            'Clearance',
        ];

        foreach($types as $type)
            DocumentTypes::create(['docType' => $type]);
    }
}
