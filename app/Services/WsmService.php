<?php

namespace App\Services;

use App\Models\EvaluationCriteria;
use App\Models\MaterialSupplierCatalog;
use Illuminate\Support\Collection;

class WsmService
{
    /**
     * Rank suppliers for a given raw material using WSM.
     */
    public function rankForRawMaterial(int $rawMaterialId, ?int $limit = null): Collection
    {
        $criteria = EvaluationCriteria::all();
        $catalogs = MaterialSupplierCatalog::with('supplier')
            ->where('raw_material_id', $rawMaterialId)
            ->get();

        if ($catalogs->isEmpty()) {
            return collect();
        }

        $filteredCriteria = $criteria->filter(function ($criterion) use ($catalogs): bool {
            $column = $this->columnNameFromCriterion($criterion->nama_kriteria);

            return $catalogs->contains(fn($catalog) => filled($catalog->{$column} ?? null));
        })->values();

        if ($filteredCriteria->isEmpty()) {
            return collect();
        }

        // Recompute sum of weights using only available criteria
        $sumWeights = $filteredCriteria->sum('bobot') ?: 1;

        $results = $catalogs->map(function ($cat) use ($filteredCriteria, $catalogs, $sumWeights) {
            $score = 0.0;

            foreach ($filteredCriteria as $crit) {
                $col = $this->columnNameFromCriterion($crit->nama_kriteria);
                $val = $cat->{$col} ?? 0;
                $vals = $catalogs->map(fn($catalog) => $catalog->{$col} ?? null)->filter()->values();

                if ($vals->isEmpty()) {
                    $norm = 0;
                } else {
                    $type = strtolower($crit->tipe ?? 'cost');
                    $isBenefit = str_contains($type, 'benef');

                    if ($isBenefit) {
                        $max = $vals->max();
                        $norm = $max > 0 ? ($val / $max) : 0;
                    } else {
                        $min = $vals->min();
                        $norm = $val > 0 ? ($min / $val) : 0;
                    }
                }

                $weight = ($crit->bobot / $sumWeights);
                $score += $norm * $weight;
            }

            return (object) [
                'supplier' => $cat->supplier,
                'catalog' => $cat,
                'score' => $score,
            ];
        });

        $sorted = $results->sortByDesc('score')->values();

        return $limit ? $sorted->take($limit) : $sorted;
    }

    /**
     * Map a human-friendly criterion name to a catalog column name.
     */
    protected function columnNameFromCriterion(string $nama): string
    {
        $key = strtolower(str_replace(' ', '_', $nama));

        $map = [
            'harga' => 'harga',
            'price' => 'harga',
            'lead_time' => 'lead_time',
            'lead time' => 'lead_time',
            'leadtime' => 'lead_time',
        ];

        return $map[$key] ?? $key;
    }
}
