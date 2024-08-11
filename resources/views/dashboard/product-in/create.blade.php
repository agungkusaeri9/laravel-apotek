@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Barang Masuk</h1>
        </div>
        <div class="pull-right">
            <a href="{{ route('product-in.index') }}" class="btn btn-warning btn-xs mb-4"><i
                    class="glyphicon glyphicon-chevron-left"> Kembali</i></a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('product-in.store') }}" method="post">
                            @csrf
                            <div class='form-group'>
                                <label for='product_id'>Barang</label>
                                <select name='product_id' id='product_id'
                                    class='form-control @error('product_id') is-invalid @enderror'>
                                    <option value='' selected disabled>Pilih Barang</option>
                                    @foreach ($barangs as $barang)
                                        <option value='{{ $barang->id }}'>{{ $barang->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='jumlah' class='mb-2'>Jumlah</label>
                                <input type='text' name='jumlah' id='jumlah'
                                    class='form-control @error('jumlah') is-invalid @enderror' value='{{ old('jumlah') }}'>
                                @error('jumlah')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='keterangan' class='mb-2'>Keterangan</label>
                                <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                    class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success">Tambah Barang Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm table-striped table-striped">
                            <tr>
                                <th class="" style="width:120px">Nama Barang</th>
                                <th style="width:10px">:</th>
                                <th id="d-nama">-</th>
                            </tr>
                            <tr>
                                <th class="">Kategori</th>
                                <th>:</th>
                                <th id="d-kategori">-</th>
                            </tr>
                            <tr>
                                <th class="">Deskripsi</th>
                                <th>:</th>
                                <th id="d-deskripsi">-</th>
                            </tr>
                            <tr>
                                <th class="">Stok Akhir</th>
                                <th>:</th>
                                <th id="d-stok">-</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $('#product_id').on('change', function() {
                    let id = $(this).val();
                    $.ajax({
                        url: '{{ route('product.getById') }}',
                        data: {
                            id: id
                        },
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(data) {
                            console.log(data);
                            $('#d-nama').html(data.nama);
                            $('#d-kategori').html(data.category.nama);
                            $('#d-deskripsi').html(data.description);
                            $('#d-stok').html(data.stok);
                        }
                    })
                })
            })
        </script>
    @endpush
@endsection
