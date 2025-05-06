<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create([
            'name' => 'chocolate',
            'price' => 22.0
        ]);

        Product::factory()->create([
            'name' => 'Helado',
            'price' => 12.0
        ]);
    }
}
