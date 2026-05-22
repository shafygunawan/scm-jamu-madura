<?php

namespace Tests\Feature;

use App\Models\RawMaterial;
use App\Models\RawMaterialReceipt;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryStockFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_receipts_and_condition_adjustments(): void
    {
        $this->actingAs(User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'Admin',
        ]));

        $supplier = Supplier::create([
            'nama' => 'Supplier A',
            'alamat' => 'Jl. Satu',
            'kontak' => '08123456789',
        ]);

        $rawMaterial = RawMaterial::create([
            'nama' => 'Jahe',
            'stok' => 0,
            'stok_baik' => 0,
            'stok_rusak' => 0,
        ]);

        $this->post(route('inventories.receive.store'), [
            'supplier_id' => $supplier->id,
            'raw_material_id' => $rawMaterial->id,
            'received_at' => '2026-05-22',
            'good_quantity' => 12,
            'damaged_quantity' => 3,
        ])->assertRedirect(route('inventories.index'));

        $this->assertDatabaseHas('raw_material_receipts', [
            'supplier_id' => $supplier->id,
            'raw_material_id' => $rawMaterial->id,
            'received_at' => '2026-05-22 00:00:00',
            'quantity' => 15,
            'good_quantity' => 12,
            'damaged_quantity' => 3,
        ]);

        $rawMaterial->refresh();
        $this->assertSame(15.0, (float) $rawMaterial->stok);
        $this->assertSame(12.0, (float) $rawMaterial->stok_baik);
        $this->assertSame(3.0, (float) $rawMaterial->stok_rusak);

        $this->post(route('inventories.raw-materials.condition-adjustments.store', $rawMaterial), [
            'from_status' => 'Baik',
            'to_status' => 'Rusak',
            'quantity' => 2,
            'adjusted_at' => '2026-05-22',
            'notes' => 'Pemeriksaan gudang',
        ])->assertRedirect(route('inventories.raw-materials.stock', $rawMaterial));

        $rawMaterial->refresh();
        $this->assertSame(15.0, (float) $rawMaterial->stok);
        $this->assertSame(10.0, (float) $rawMaterial->stok_baik);
        $this->assertSame(5.0, (float) $rawMaterial->stok_rusak);

        $this->assertDatabaseHas('raw_material_condition_adjustments', [
            'raw_material_id' => $rawMaterial->id,
            'from_status' => 'Baik',
            'to_status' => 'Rusak',
            'quantity' => 2,
            'adjusted_at' => '2026-05-22 00:00:00',
        ]);

        $this->get(route('inventories.raw-materials.stock', $rawMaterial))
            ->assertOk()
            ->assertSee('Supplier A')
            ->assertSee('Stok per Supplier')
            ->assertSee('Mutasi Kondisi');
    }
}
