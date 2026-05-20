<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'alamat', 'kontak', 'dokumen_legal', 'preferred'])]
class Supplier extends Model
{
    use HasFactory;

    public function catalogs()
    {
        return $this->hasMany(MaterialSupplierCatalog::class);
    }

    public function ratings()
    {
        return $this->hasMany(SupplierRating::class);
    }
}
