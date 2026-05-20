<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'stok'])]
class RawMaterial extends Model
{
    use HasFactory;

    public function catalogs()
    {
        return $this->hasMany(MaterialSupplierCatalog::class);
    }
}
