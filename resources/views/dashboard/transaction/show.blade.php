@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Transaksi</h1>
        </div>
        <div class="pull-right">
            <a href="{{ route('transaksi.index') }}" class="btn btn-warning btn-xs mb-4"><i
                    class="glyphicon glyphicon-chevron-left"> Kembali</i></a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-3">Detail Penjualan</h4>
                        </div>
                        <table class="table table-borderless mt-4">
                            <tr>
                                <th>Invoice</th>
                                <td>{{ $item->invoice }}</td>
                            </tr>
                            <tr>
                                <th>Sub Total</th>
                                <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Diskon</th>
                                <td>Rp {{ number_format($item->diskon, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Tunai</th>
                                <td>Rp {{ number_format($item->tunai, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Kembalian</th>
                                <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $item->created_at->translatedFormat('H:i:s d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Created</th>
                                <td>{{ $item->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td>
                                    <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-warning">Kembali</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-3">Detail Barang</h4>
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table dtTable table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->details as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->product->nama }}</td>
                                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                            <td>{{ $detail->jumlah }}</td>
                                            <td>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
