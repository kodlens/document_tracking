<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                'route_name' => 'GADTC Payroll',
                'remarks' => ''
            ],
            [
                'route_name' => 'Sample 1',
                'remarks' => ''
            ],
            [
                'route_name' => 'Sample 2',
                'remarks' => ''
            ],
            
        ];

        \App\Models\DocumentRoute::insertOrIgnore($data);

    }
}
