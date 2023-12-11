<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
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
                'user_id' => 2,
                'tracking_no' => 'C673C894C1CBC01',
                'document_name' => 'PAYROLL DEC 1-15',
                'route_id' => 1,
                'is_done' => 0,
                'is_forwarded' => 0
            ],

        ];

        \App\Models\Document::insertOrIgnore($data);

    }
}
