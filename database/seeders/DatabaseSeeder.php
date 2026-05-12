<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        User::create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Pembeli Biasa',
            'email' => 'pembeli@gmail.com',
            'password' => bcrypt('pembeli123'),
            'role' => 'pembeli'
        ]);
    }
}
