<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SizeCoffeeSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('size_coffees')->insert([
            ['name' => 'Small', 'ml' => 150],
            ['name' => 'Medium', 'ml' => 250],
            ['name' => 'Large', 'ml' => 500]
        ]);
    }
}
