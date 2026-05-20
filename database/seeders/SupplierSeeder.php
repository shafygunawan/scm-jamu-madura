<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            ['nama' => 'Supplier A', 'alamat' => 'Alamat A', 'kontak' => '081234567890'],
            ['nama' => 'Supplier B', 'alamat' => 'Alamat B', 'kontak' => '081298765432'],
        ];

        foreach ($samples as $s) {
            Supplier::firstOrCreate(['nama' => $s['nama']], $s);
        }
    }
}
