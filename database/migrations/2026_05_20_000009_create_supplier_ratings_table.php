<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->foreignId('criteria_id')->constrained('evaluation_criteria')->cascadeOnDelete();
            $table->decimal('nilai', 8, 2)->default(0);
            $table->decimal('skor', 8, 4)->default(0);
            $table->timestamps();

            $table->unique(['supplier_id', 'criteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_ratings');
    }
};
