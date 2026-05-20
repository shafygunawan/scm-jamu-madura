<?php

namespace Database\Seeders;

use App\Models\EvaluationCriteria;
use Illuminate\Database\Seeder;

class EvaluationCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            ['nama_kriteria' => 'Harga', 'tipe' => 'Cost', 'bobot' => 0.6667],
            ['nama_kriteria' => 'Lead Time', 'tipe' => 'Cost', 'bobot' => 0.3333],
        ];

        foreach ($criteria as $c) {
            EvaluationCriteria::firstOrCreate(['nama_kriteria' => $c['nama_kriteria']], $c);
        }
    }
}
