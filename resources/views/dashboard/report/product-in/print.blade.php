<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
            /* background-color: #f3f3f3; */
        }

        table.tbl {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        table.tbl thead {
            background-color: #4CAF50;
            color: white;
        }

        table.tbl th,
        table.tbl td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table.tbl th {
            background-color: #4CAF50;
            color: white;
        }

        table.tbl tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table.tbl tr:hover {
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
        <h2 class="text-center">Laporan Barang Masuk</h2>
        <table>
            @if (request('dari'))
                <tr>
                    <th>Dari</th>
                    <th>:</th>
                    <th>{{ request('dari') }}</th>
                </tr>
            @endif
            @if (request('sampai'))
                <tr>
                    <th>Sampai</th>
                    <th>:</th>
                    <th>{{ request('sampai') }}</th>
                </tr>
            @endif
        </table>
        <table class="tbl" style="margin-top:10px">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Keterangan</th>
                    <th>Jumlah Masuk</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->translatedFormat('d/m/Y') }}</td>
                        <td class="text-left">{{ $item->product->nama }}</td>
                        <td>{{ $item->product->category->nama }}</td>
                        <td class="text-left">{{ $item->product->description }}</td>
                        <td class="text-left">{{ $item->keterangan }}</td>
                        <td>{{ $item->jumlah }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">Data Tidak Ada!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
