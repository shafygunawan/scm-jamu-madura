<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'supplier_id',
    'raw_material_id',
    'received_at',
    'quantity',
    'good_quantity',
    'damaged_quantity',
    'remaining_good_quantity',
    'remaining_damaged_quantity',
])]
class RawMaterialReceipt extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'received_at' => 'date',
        ];
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }
}
