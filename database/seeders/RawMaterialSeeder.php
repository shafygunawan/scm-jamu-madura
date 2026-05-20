<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class RawMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['nama' => 'Jahe', 'stok' => 100],
            ['nama' => 'Kunyit', 'stok' => 80],
            ['nama' => 'Temulawak', 'stok' => 60],
        ];

        foreach ($materials as $m) {
            RawMaterial::firstOrCreate(['nama' => $m['nama']], $m);
        }
    }
}
