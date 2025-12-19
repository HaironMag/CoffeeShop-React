<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CoffeeSeeder extends Seeder
{
    public function run(): void {
        \Illuminate\Support\Facades\DB::table('coffees')->insert([
            [
                'name' => 'Эспрессо',
                'description' => 'Крепкий и согревающий ваш день.',
                'price' => 250.00,
                'size_id' => 1,
                'available' => true,
                'image' => 'storage/coffees/espresso.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Latte',
                'description' => 'Creamy milk with rich espresso.',
                'price' => 500.00,
                'size_id' => 2,
                'available' => true,
                'image' => 'storage/coffees/latte.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Какао с Маршмэллоу',
                'description' => 'Мягкое маршмэллоу в сливочном Какао',
                'price' => 750.00,
                'size_id' => 3,
                'available' => true,
                'image' => 'storage/coffees/Какао с Маршмэллоу.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
