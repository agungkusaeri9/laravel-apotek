<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
            /* background-color: #f3f3f3; */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        thead {
            background-color: #4CAF50;
            color: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        tfoot {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Laporan Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Stok Awal</th>
                    <th>Stok Akhir</th>
                    <th>Jumlah Masuk</th>
                    <th>Jumlah Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $product->nama }}</td>
                        <td>{{ $product->category->nama }}</td>
                        <td class="text-left">{{ $product->description }}</td>
                        <td>{{ $product->stok_awal }}</td>
                        <td>{{ $product->stok }}</td>
                        <td>{{ $product->product_in->sum('jumlah') }}</td>
                        <td>{{ $product->product_out->sum('jumlah') }}</td>
                    </tr>
                @endforeach
                <!-- Tambahkan baris lainnya sesuai kebutuhan -->
            </tbody>
            {{-- <tfoot>
                <tr>
                    <td colspan="3">Total</td>
                    <td>70</td>
                    <td>-</td>
                    <td>-</td>
                    <td>55</td>
                    <td>30</td>
                    <td>45</td>
                </tr>
            </tfoot> --}}
        </table>
    </div>
</body>

</html>
