<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'raw_material_id',
    'raw_material_receipt_id',
    'from_status',
    'to_status',
    'quantity',
    'adjusted_at',
    'notes',
])]
class RawMaterialConditionAdjustment extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'adjusted_at' => 'date',
        ];
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function receipt()
    {
        return $this->belongsTo(RawMaterialReceipt::class, 'raw_material_receipt_id');
    }
}
