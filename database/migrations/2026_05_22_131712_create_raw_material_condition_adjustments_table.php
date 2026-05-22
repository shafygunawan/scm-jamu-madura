<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raw_material_condition_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_material_id')->constrained()->cascadeOnDelete();
            $table->foreignId('raw_material_receipt_id')->nullable()->constrained('raw_material_receipts')->nullOnDelete();
            $table->string('from_status');
            $table->string('to_status');
            $table->double('quantity')->default(0);
            $table->date('adjusted_at');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->index(['raw_material_id', 'adjusted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_condition_adjustments');
    }
};
