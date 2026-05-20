<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['supplier_id', 'criteria_id', 'nilai', 'skor'])]
class SupplierRating extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criteria_id');
    }
}
