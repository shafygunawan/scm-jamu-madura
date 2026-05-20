<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_kriteria', 'tipe', 'bobot'])]
class EvaluationCriteria extends Model
{
    use HasFactory;

    /**
     * Explicit table name because "criteria" is already plural.
     * Eloquent's pluralizer would create 'evaluation_criterias' otherwise.
     *
     * @var string
     */
    protected $table = 'evaluation_criteria';
}
