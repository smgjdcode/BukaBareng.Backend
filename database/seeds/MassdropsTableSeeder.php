<?php

use Illuminate\Database\Seeder;

class MassdropsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('massdrops')->insert([
            'id' => 1,
            'product_id' => '1683px',
            'lower_bound' => 12,
            'lower_price' => '45000',
            'quantity' => 10,
            'deadline' => '10-10-2017'
        ]);
        DB::table('massdrops')->insert([
            'id' => 2,
            'product_id' => '85wxai',
            'lower_bound' => 12,
            'lower_price' => '80000',
            'quantity' => 10,
            'deadline' => '10-10-2017'
        ]);
        DB::table('massdrops')->insert([
            'id' => 3,
            'product_id' => 'bnkk7',
            'lower_bound' => 50,
            'lower_price' => '35000',
            'quantity' => 10,
            'deadline' => '10-10-2017'
        ]);


    }
}
