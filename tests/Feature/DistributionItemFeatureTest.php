<?php

namespace Tests\Feature;

use App\Models\Distributor;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistributionItemFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_shipment_items_and_reduces_product_stock(): void
    {
        $this->actingAs(User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'Admin',
        ]));

        $distributor = Distributor::create([
            'nama' => 'Distributor A',
            'alamat' => 'Jl. Dua',
            'kontak' => '0811111111',
        ]);

        $product = Product::create([
            'nama' => 'Kapsul Jamu',
            'stok' => 10,
        ]);

        $this->post(route('distributions.store'), [
            'distributor_id' => $distributor->id,
            'tanggal_pengiriman' => '2026-05-22',
            'status' => 'Diproses',
            'status_pembayaran' => 'Pending',
            'items' => [
                ['product_id' => $product->id, 'quantity' => 4],
            ],
        ])->assertRedirect(route('distributions.index'));

        $shipment = Shipment::query()->firstOrFail();

        $this->assertDatabaseHas('shipment_items', [
            'shipment_id' => $shipment->id,
            'product_id' => $product->id,
            'quantity' => 4,
        ]);

        $product->refresh();
        $this->assertSame(6, $product->stok);

        $this->get(route('distributions.items', $shipment))
            ->assertOk()
            ->assertSee('Kapsul Jamu')
            ->assertSee('4');
    }
}
