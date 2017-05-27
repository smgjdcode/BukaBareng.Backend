<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '22659671',
            'username' => "Satria Bagus",
            'balance' => 300000
        ]);
        DB::table('users')->insert([
            'id' => '157324',
            'username' => "Sayur Kangkung",
            'balance' => 400000
        ]);
        DB::table('users')->insert([
            'id' => '32856476',
            'username' => "bdc_seller",
            'balance' => 400000
        ]);

    }
}
