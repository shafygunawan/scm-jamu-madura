<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'alamat', 'kontak'])]
class Distributor extends Model
{
    use HasFactory;

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
