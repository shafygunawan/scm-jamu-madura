<?php

namespace Database\Seeders;

use App\Models\EvaluationCriteria;
use Illuminate\Database\Seeder;

class EvaluationCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            ['nama_kriteria' => 'Harga', 'tipe' => 'Cost', 'bobot' => 0.4],
            ['nama_kriteria' => 'Kualitas', 'tipe' => 'Benefit', 'bobot' => 0.3],
            ['nama_kriteria' => 'Lead Time', 'tipe' => 'Cost', 'bobot' => 0.2],
            ['nama_kriteria' => 'Performa', 'tipe' => 'Benefit', 'bobot' => 0.1],
        ];

        foreach ($criteria as $c) {
            EvaluationCriteria::firstOrCreate(['nama_kriteria' => $c['nama_kriteria']], $c);
        }
    }
}
