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
                'lname' => 'CENAS',
                'fname' => 'VINZ',
                'mname' => 'P',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'vinz@dev.com',
                'contact_no' => '09165678414',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],



        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
