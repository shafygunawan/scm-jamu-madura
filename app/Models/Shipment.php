<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['distributor_id', 'tanggal_pengiriman', 'status', 'status_pembayaran'])]
class Shipment extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'tanggal_pengiriman' => 'date',
        ];
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
