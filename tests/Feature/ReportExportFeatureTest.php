<?php

namespace Tests\Feature;

use App\Models\RawMaterial;
use App\Models\RawMaterialReceipt;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportExportFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_passes_report_generation_metadata_and_inventory_breakdown_to_pdf(): void
    {
        $this->actingAs(User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => 'password',
            'role' => 'Manager',
        ]));

        $supplier = Supplier::create([
            'nama' => 'Supplier Laporan',
            'alamat' => 'Jl. Tiga',
            'kontak' => '0899999999',
        ]);

        $rawMaterial = RawMaterial::create([
            'nama' => 'Kunyit',
            'stok' => 8,
            'stok_baik' => 8,
            'stok_rusak' => 0,
        ]);

        RawMaterialReceipt::create([
            'supplier_id' => $supplier->id,
            'raw_material_id' => $rawMaterial->id,
            'received_at' => '2026-05-22',
            'quantity' => 8,
            'good_quantity' => 8,
            'damaged_quantity' => 0,
            'remaining_good_quantity' => 8,
            'remaining_damaged_quantity' => 0,
        ]);

        $pdf = \Mockery::mock(\Barryvdh\DomPDF\PDF::class);

        Pdf::shouldReceive('loadView')
            ->once()
            ->with('reports.pdf', \Mockery::on(function (array $payload): bool {
                return array_key_exists('generatedAt', $payload)
                    && array_key_exists('rawMaterials', $payload)
                    && array_key_exists('rawMaterialBreakdowns', $payload);
            }))
            ->andReturn($pdf);

        $pdf->shouldReceive('setPaper')->once()->with('a4', 'portrait')->andReturnSelf();
        $pdf->shouldReceive('stream')->once()->with('report_inventory.pdf')->andReturn(response('ok'));

        $this->get(route('reports.export', ['type' => 'inventory']))
            ->assertOk()
            ->assertSee('ok');
    }
}
