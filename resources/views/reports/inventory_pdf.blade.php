<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Inventory Report</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rawMaterials ?? collect() as $i => $rm)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $rm->nama }}</td>
                    <td>{{ $rm->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
