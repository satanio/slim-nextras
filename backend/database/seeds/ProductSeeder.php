<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ProductSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Laptop Dell XPS 13',
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
                'price' => 1299.99,
                'stock' => 15,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with A17 Pro chip and 256GB storage',
                'price' => 1099.99,
                'stock' => 25,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Flagship Android phone with 12GB RAM',
                'price' => 899.99,
                'stock' => 30,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Premium noise-cancelling wireless headphones',
                'price' => 399.99,
                'stock' => 50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Apple Watch Series 9',
                'description' => 'Smart watch with health monitoring features',
                'price' => 429.99,
                'stock' => 40,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'iPad Air',
                'description' => 'Versatile tablet with M1 chip and 64GB storage',
                'price' => 599.99,
                'stock' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'MacBook Pro 14"',
                'description' => 'Professional laptop with M3 Pro chip',
                'price' => 1999.99,
                'stock' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Kindle Paperwhite',
                'description' => 'E-reader with adjustable warm light',
                'price' => 139.99,
                'stock' => 60,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'GoPro HERO 12',
                'description' => '5.3K action camera with HyperSmooth stabilization',
                'price' => 449.99,
                'stock' => 35,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Gaming console with vibrant OLED screen',
                'price' => 349.99,
                'stock' => 45,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('products')->insert($data)->saveData();
    }
}

