<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'username' => 'admin',
                'lname' => 'PUCOT',
                'fname' => 'MARJHON',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'office_id' => 0,
                'contact_no' => '09655138165',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],

            [
                'username' => 'arnel',
                'lname' => 'SELATONA',
                'fname' => 'ARNEL',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'office_id' => 0,
                'contact_no' => '09655138165',
                'role' => 'LIAISON',
                'password' => Hash::make('a')
            ],

            [
                'username' => 'liason',
                'lname' => 'SELATONA',
                'fname' => 'ARNEL',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'office_id' => 0,
                'contact_no' => '09655138165',
                'role' => 'STAFF',
                'password' => Hash::make('a')
            ],


            [
                'username' => 'tcgc-accounting',
                'lname' => 'YANG',
                'fname' => 'RUSMA',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'office_id' => 1,
                'contact_no' => '1324564',
                'role' => 'STAFF',
                'password' => Hash::make('a')
            ],
            [
                'username' => 'city-budget',
                'lname' => 'COMPO',
                'fname' => 'MITCH',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'office_id' => 2,
                'contact_no' => '1324564',
                'role' => 'STAFF',
                'password' => Hash::make('a')
            ],
            [
                'username' => 'city-accounting',
                'lname' => 'DELA CRUZ',
                'fname' => 'JENIFEE',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'office_id' => 3,
                'contact_no' => '1324564',
                'role' => 'STAFF',
                'password' => Hash::make('a')
            ],
            [
                'username' => 'city-treasury',
                'lname' => 'ANNE',
                'fname' => 'MAY',
                'mname' => '',
                'suffix' => '',
                'sex' => 'MALE',
                'office_id' => 4,
                'contact_no' => '1324564',
                'role' => 'STAFF',
                'password' => Hash::make('a')
            ],




        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
