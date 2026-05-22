<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['shipment_id', 'product_id', 'quantity'])]
class ShipmentItem extends Model
{
    use HasFactory;

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
