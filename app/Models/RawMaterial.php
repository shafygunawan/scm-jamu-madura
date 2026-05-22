<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'stok', 'stok_baik', 'stok_rusak'])]
class RawMaterial extends Model
{
    use HasFactory;

    public function catalogs()
    {
        return $this->hasMany(MaterialSupplierCatalog::class);
    }

    public function receipts()
    {
        return $this->hasMany(RawMaterialReceipt::class);
    }

    public function conditionAdjustments()
    {
        return $this->hasMany(RawMaterialConditionAdjustment::class);
    }
}
