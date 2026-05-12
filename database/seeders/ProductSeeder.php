<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Pake firstOrCreate biar kalau kategorinya belum ada, dia buatin otomatis.
        // Jadi nggak bakal error "null" lagi dan data manual lu tetep aman.
        $gear = Category::firstOrCreate(['name' => 'Gaming Gear']);
        $topup = Category::firstOrCreate(['name' => 'Top Up Game']);
        $voucher = Category::firstOrCreate(['name' => 'Voucher']);
        $chair = Category::firstOrCreate(['name' => 'Gaming Chair']);

        $products = [
            // --- GAMING GEAR ---
            ['category_id' => $gear->id, 'name' => 'Logitech G Pro X Superlight', 'price' => 2100000, 'stock' => 5],
            ['category_id' => $gear->id, 'name' => 'SteelSeries Apex Pro TKL', 'price' => 3200000, 'stock' => 3],
            ['category_id' => $gear->id, 'name' => 'Razer BlackShark V2 Pro', 'price' => 2500000, 'stock' => 10],
            ['category_id' => $gear->id, 'name' => 'HyperX QuadCast S', 'price' => 2300000, 'stock' => 7],

            // --- TOP UP GAME ---
            ['category_id' => $topup->id, 'name' => '999 Diamonds', 'game_name' => 'Mobile Legends', 'price' => 245000, 'stock' => 999],
            ['category_id' => $topup->id, 'name' => '6000 VP', 'game_name' => 'Valorant', 'price' => 900000, 'stock' => 5000],
            ['category_id' => $topup->id, 'name' => '3280+600 Oneiric Shard', 'game_name' => 'Honkai Star Rail', 'price' => 799000, 'stock' => 999],
            ['category_id' => $topup->id, 'name' => '8080 Genesis Crystals', 'game_name' => 'Genshin Impact', 'price' => 1500000, 'stock' => 999],
            ['category_id' => $topup->id, 'name' => '1000 Wild Cores', 'game_name' => 'Wild Rift', 'price' => 150000, 'stock' => 999],

            // --- VOUCHER ---
            ['category_id' => $voucher->id, 'name' => 'Steam Wallet IDR 120.000', 'price' => 135000, 'stock' => 100],
            ['category_id' => $voucher->id, 'name' => 'Google Play Gift Card 100rb', 'price' => 110000, 'stock' => 50],
            ['category_id' => $voucher->id, 'name' => 'PlayStation Network $20', 'price' => 310000, 'stock' => 25],

            // --- CHAIR ---
            ['category_id' => $chair->id, 'name' => 'Secretlab TITAN Evo 2022', 'price' => 7500000, 'stock' => 2],
            ['category_id' => $chair->id, 'name' => 'DXRacer Prince Series', 'price' => 3500000, 'stock' => 8],
        ];

        foreach ($products as $product) {
            // Biar nggak double kalau lu running seeder berkali-kali
            Product::firstOrCreate(
                ['name' => $product['name']], // Cek berdasarkan nama produk
                $product
            );
        }
    }
}
