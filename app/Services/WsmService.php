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

        $sumWeights = $criteria->sum('bobot') ?: 1;

        // Prepare values per criterion
        $valuesByCriterion = [];
        foreach ($criteria as $c) {
            $col = $this->columnNameFromCriterion($c->nama_kriteria);
            $vals = $catalogs->map(fn ($cat) => $cat->{$col} ?? null)->filter()->values();
            $valuesByCriterion[$c->id] = [
                'criterion' => $c,
                'values' => $vals,
            ];
        }

        $results = $catalogs->map(function ($cat) use ($criteria, $valuesByCriterion, $sumWeights) {
            $score = 0.0;

            foreach ($criteria as $crit) {
                $col = $this->columnNameFromCriterion($crit->nama_kriteria);
                $val = $cat->{$col} ?? 0;
                $vals = $valuesByCriterion[$crit->id]['values'] ?? collect();

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
