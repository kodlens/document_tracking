<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RouteDetailSeeder extends Seeder
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
                'route_id' => 1,
                'order_no' => 2,
                'office_id' => 10,
                'is_origin' => 0,
                'is_last' => 0

            ],
            [
                'route_id' => 1,
                'order_no' => 3,
                'office_id' => 2,
                'is_origin' => 0,
                'is_last' => 0
            ],
            [
                'route_id' => 1,
                'order_no' => 4,
                'office_id' => 4,
                'is_origin' => 0,
                'is_last' => 1
            ],
            [
                'route_id' => 1,
                'order_no' => 1,
                'office_id' => 11,
                'is_origin' => 1,
                'is_last' => 0
            ],
            
            
        ];

        \App\Models\DocumentRouteDetail::insertOrIgnore($data);


    }
}
