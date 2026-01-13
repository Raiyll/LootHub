<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $gear = \App\Models\Category::create(['name' => 'Gaming Gear']);
    $topup = \App\Models\Category::create(['name' => 'Top Up Game']);

    \App\Models\Product::create([
        'category_id' => $gear->id,
        'name' => 'Logitech G Pro X Superlight',
        'price' => 2100000,
        'stock' => 5
    ]);

    \App\Models\Product::create([
        'category_id' => $topup->id,
        'name' => '999 Diamonds',
        'game_name' => 'Mobile Legends',
        'price' => 245000,
        'stock' => 999
    ]);

    \App\Models\Product::create([
        'category_id' => $topup->id,
        'name' => '6000 VP',
        'game_name' => 'Valorant',
        'price' => 900000,
        'stock' => 5000
    ]);

    \App\Models\User::create([
    'name' => 'Admin Ganteng',
    'email' => 'admin@gmail.com',
    'password' => bcrypt('admin123'),
    'role' => 'admin'
]);

\App\Models\User::create([
    'name' => 'Kasir Toko',
    'email' => 'kasir@gmail.com',
    'password' => bcrypt('kasir123'),
    'role' => 'kasir'
]);

\App\Models\User::create([
    'name' => 'Pembeli Biasa',
    'email' => 'pembeli@gmail.com',
    'password' => bcrypt('pembeli123'),
    'role' => 'pembeli'
]);
}
}
