<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
             [
                'name' => 'Lenovo Lptop',
                'price' => 3000000,
                'stock' => 10,
                'created_at' => now(),  
                'updated_at' => now(),
             ],
             [
                'name' => 'Asus Laptop',
                'price' => 4000000,
                'stock' => 15,
                'created_at' => now(),  
                'updated_at' => now(),
                ],
                [
                'name' => 'Acer Laptop',
                'price' => 3500000,
                'stock' => 20,
                'created_at' => now(),  
                'updated_at' => now(),  
                ],
                [
                'name' => 'HP Laptop',
                'price' => 4500000,
                'stock' => 5,
                'created_at' => now(),  
                'updated_at' => now(),  
                ],
                [
                'name' => 'Dell Laptop',
                'price' => 3200000,
                'stock' => 8,
                'created_at' => now(),
                'updated_at' => now(),
                ]
        ]);
    }
}
