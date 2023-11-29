<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductModel;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker=Faker::create();

        for($i=1;$i <= 50;$i++){
            $product=new ProductModel;

            $product->product_name=$faker->word;
            $product->product_price=$faker->numberBetween(10000,20000);

            $product->save();
        }
    }
}
