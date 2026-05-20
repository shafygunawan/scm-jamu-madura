<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['nama' => 'Jamu Pegal Linu', 'stok' => 50],
        ];

        foreach ($products as $p) {
            Product::firstOrCreate(['nama' => $p['nama']], $p);
        }
    }
}
