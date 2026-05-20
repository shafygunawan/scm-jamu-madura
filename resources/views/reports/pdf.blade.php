<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan SCM</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #111827;
            padding-bottom: 12px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            margin: 4px 0 0;
            color: #4b5563;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
        }

        .section {
            margin-top: 24px;
        }

        .section h2 {
            margin: 0 0 8px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="title">Laporan SCM Jamu Madura</p>
        <p class="subtitle">Jenis laporan: {{ ucfirst($type) }}</p>
    </div>

    @if ($type === 'inventory')
        <div class="section">
            <h2>Bahan Baku</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rawMaterials as $index => $rawMaterial)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $rawMaterial->nama }}</td>
                            <td>{{ $rawMaterial->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Tidak ada data bahan baku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Produk Jadi</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->nama }}</td>
                            <td>{{ $product->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @elseif ($type === 'production')
        <div class="section">
            <h2>Batch Produksi</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productionBatches as $index => $batch)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $batch->tanggal }}</td>
                            <td>{{ $batch->product?->nama ?? '-' }}</td>
                            <td>{{ $batch->jumlah }}</td>
                            <td>{{ $batch->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada data produksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="section">
            <h2>Pengiriman</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Distributor</th>
                        <th>Status Pengiriman</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shipments as $index => $shipment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $shipment->tanggal_pengiriman }}</td>
                            <td>{{ $shipment->distributor?->nama ?? '-' }}</td>
                            <td>{{ $shipment->status }}</td>
                            <td>{{ $shipment->status_pembayaran }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada data pengiriman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</body>

</html>
