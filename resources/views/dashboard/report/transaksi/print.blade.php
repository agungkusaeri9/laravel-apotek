<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $ititle ?? 'Laporan Barang Masuk' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            /* Ukuran font lebih kecil */
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
            /* Ukuran font tabel */
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 6px;
        }

        th.main {
            background-color: #0c0b0b;
            font-size: 12px;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .judul {
            margin-bottom: 40px
        }
    </style>
</head>

<body>
    <h2 class="text-center judul">Laporan Transaksi</h2>

    <table>
        <tr>
            <th class="main">No.</th>
            <th class="main">Tanggal</th>
            <th class="main">Invoice</th>
            <th class="main">Sub Total</th>
            <th class="main">Diskon</th>
            <th class="main">Total</th>
            <th class="main">Tunai</th>
            <th class="main">Kembalian</th>
            <th class="main">Created</th>
        </tr>
        @foreach ($items as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->created_at->translatedFormat('d/m/Y H:i:s') }}</td>
                <td>{{ $item->invoice }}</td>
                <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->diskon, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->tunai, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                <td>{{ $item->user->name }}</td>
            </tr>
        @endforeach
        <tfoot>
            <tr>
                <th colspan="5" class="text-center"><b>Total</b></th>
                <td colspan="4">
                    <b>Rp {{ $items ? number_format($items->sum('total_harga')) : '0' }}</b>
                </td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
