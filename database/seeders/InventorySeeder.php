<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
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
                'item_id' => 1,
                'qty' => 0,
            ],
            [
                'item_id' => 2,
                'qty' => 0,
            ],
            [
                'item_id' => 3,
                'qty' => 0,
            ],
            [
                'item_id' => 4,
                'qty' => 0,
            ],
           

        ];

        \App\Models\Inventory::insertOrIgnore($data);

    }
}
