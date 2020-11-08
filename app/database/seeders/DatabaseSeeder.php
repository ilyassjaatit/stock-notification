<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class
        ]);
        $categores = Category::all();
        Product::all()->each(function ($product) use ($categores) {
            $product->categories()->attach(
                $categores->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
