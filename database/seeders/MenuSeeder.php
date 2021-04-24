<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 50; $i++) {
            # code...
            DB::table('menus')->insert([
                'name' => $faker->name,
                'price' => $faker->numberBetween(500,100000),
                'description' => $faker->sentence,
                'image' => '1619234577nasi-goreng-pedas_43.jpeg'
            ]);
        }
    }
}
