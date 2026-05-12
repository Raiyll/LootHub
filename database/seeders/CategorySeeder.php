<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Gaming Gear'],
            ['name' => 'Top Up Game'],
            ['name' => 'Voucher'],
            ['name' => 'Gaming Chair'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
