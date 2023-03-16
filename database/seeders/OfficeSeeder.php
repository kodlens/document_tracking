<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
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
                'office' => 'IBFS',
                'designate_person' => '',
                'designation' => ''
            ],
            [
                'office' => 'ICJE',
                'designate_person' => '',
                'designation' => ''
            ],
            [
                'office' => 'ICS',
                'designate_person' => '',
                'designation' => ''
            ],
            [
                'office' => 'ACCOUNTING',
                'designate_person' => '',
                'designation' => ''
            ],
            [
                'office' => 'CISO',
                'designate_person' => 'FRITZIE ANN FLORIDA',
                'designation' => 'CISO HEAD'
            ],
            [
                'office' => 'REGISTRAR',
                'designate_person' => '',
                'designation' => ''
            ],
            [
                'office' => 'OSA',
                'designate_person' => '',
                'designation' => ''
            ],
            [
                'office' => 'GUIDANCE',
                'designate_person' => 'BERNICE SUMALINOG',
                'designation' => 'GUIDANCE COUNCILOR'
            ],

        ];

        \App\Models\Office::insertOrIgnore($data);
    }
}
