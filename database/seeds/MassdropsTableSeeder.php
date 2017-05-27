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
            'product_id' => '85uhbu',
            'lower_bound' => 12,
            'lower_price' => '42000',
            'quantity' => 10,
            'deadline' => '10-10-2017',
            'product_name' =>'Setelan Futsal Jersey Bola Jersey Futsal Nike TR FC ',
            'product_img' => 'https://s1.bukalapak.com/img/1630805421/large/image.jpg'
        ]);
        DB::table('massdrops')->insert([
            'id' => 2,
            'product_id' => '7xqqo5',
            'lower_bound' => 6,
            'lower_price' => '45000',
            'quantity' => 7,
            'deadline' => '10-10-2017',
            'product_name' =>'Setelan Futsal Jersey Bola Jersey Futsal Nike Batique Abstack"',
            'product_img' => 'https://s1.bukalapak.com/img/1587159121/large/image.jpg'
        ]);

        DB::table('massdrops')->insert([
            'id' => 3,
            'product_id' => '81d5tk',
            'lower_bound' => 6,
            'lower_price' => '45000',
            'quantity' => 4,
            'deadline' => '10-10-2017',
            'product_name' =>'Setelan Futsal Jersey Bola Jersey Futsal Adidas ZX Putih',
            'product_img' => "https://s1.bukalapak.com/img/1563159121/large/image.jpg"
        ]);


    }
}
