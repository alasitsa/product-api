<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private array $products = [
        [
            'name' => 'Samsung Galaxy S22',
            'price' => 2500,
            'rent_price' => 100
        ],
        [
            'name' => 'Samsung Galaxy S21',
            'price' => 2000,
            'rent_price' => 70
        ],
        [
            'name' => 'Iphone 14',
            'price' => 2500,
            'rent_price' => 150
        ],
        [
            'name' => 'Xiaomi Redmi 10A',
            'price' => 800,
            'rent_price' => 20
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->products as $product) {
            Product::factory()->create($product);
        }
    }
}
