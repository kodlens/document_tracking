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
                'office' => 'TCGC - ACCOUNTING',
                'incharge' => 'ROSMARIE P. DUHAYLUNGSOD',
                'designation' => ''
            ],
            [
                'office' => 'CITY - BUDGET OFFICE',
                'incharge' => 'MITCH COMPO',
                'designation' => ''
            ],
            [
                'office' => 'CITY - ACCOUNTING',
                'incharge' => 'JENIFEE',
                'designation' => ''
            ],

            [
                'office' => 'CITY - TREASURY',
                'incharge' => 'MAY ANNE',
                'designation' => ''
            ],

            [
                'office' => 'IBFS',
                'incharge' => '',
                'designation' => ''
            ],
            [
                'office' => 'ICJE',
                'incharge' => '',
                'designation' => ''
            ],
            [
                'office' => 'ICS',
                'incharge' => '',
                'designation' => ''
            ],
           
            [
                'office' => 'CISO',
                'incharge' => 'FRITZIE ANN FLORIDA',
                'designation' => 'CISO HEAD'
            ],
            [
                'office' => 'REGISTRAR',
                'incharge' => '',
                'designation' => ''
            ],
            [
                'office' => 'OSA',
                'incharge' => '',
                'designation' => ''
            ],
            [
                'office' => 'GUIDANCE',
                'incharge' => 'BERNICE SUMALINOG',
                'designation' => 'GUIDANCE COUNCILOR'
            ],

        ];

        \App\Models\Office::insertOrIgnore($data);
    }
}
