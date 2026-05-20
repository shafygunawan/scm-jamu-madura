<?php

namespace Database\Seeders;

use App\Models\Distributor;
use Illuminate\Database\Seeder;

class DistributorSeeder extends Seeder
{
    public function run(): void
    {
        $distributors = [
            ['nama' => 'Distributor X', 'alamat' => 'Alamat X', 'kontak' => '081300000001'],
        ];

        foreach ($distributors as $d) {
            Distributor::firstOrCreate(['nama' => $d['nama']], $d);
        }
    }
}
