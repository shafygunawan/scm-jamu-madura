<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_supplier_catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->foreignId('raw_material_id')->constrained('raw_materials')->cascadeOnDelete();
            $table->decimal('harga', 12, 2)->default(0);
            $table->integer('lead_time')->default(0)->comment('days');
            $table->timestamps();

            $table->unique(['supplier_id', 'raw_material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_supplier_catalogs');
    }
};
