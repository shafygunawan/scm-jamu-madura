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
        Schema::create('raw_material_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('raw_material_id')->constrained()->cascadeOnDelete();
            $table->date('received_at');
            $table->double('quantity')->default(0);
            $table->double('good_quantity')->default(0);
            $table->double('damaged_quantity')->default(0);
            $table->double('remaining_good_quantity')->default(0);
            $table->double('remaining_damaged_quantity')->default(0);
            $table->timestamps();

            $table->index(['raw_material_id', 'supplier_id']);
            $table->index('received_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_receipts');
    }
};
