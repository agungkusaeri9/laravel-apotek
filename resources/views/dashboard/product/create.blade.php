@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Barang</h1>
        </div>
        <div class="pull-right">
            <a href="{{ route('product.index') }}" class="btn btn-warning btn-xs mb-4"><i
                    class="glyphicon glyphicon-chevron-left"> Kembali</i></a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="{{ route('product.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama Barang</label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror" required autofocus>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="custom-select mr-sm-2  @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                        @if (old('categori_id') == $category->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->nama }}</option>
                                        @endif
                                        <option value="{{ $category->id }}" selected>{{ $category->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group'>
                                <label for='unit_id'>Satuan</label>
                                <select name='unit_id' id='unit_id'
                                    class='form-control @error('unit_id') is-invalid @enderror'>
                                    <option value='' selected disabled>Pilih Satuan</option>
                                    @foreach ($units as $unit)
                                        <option value='{{ $unit->id }}'>{{ $unit->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga"
                                    class="form-control @error('harga') is-invalid @enderror" required>
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="diskon">Diskon</label>
                                <input type="number" name="diskon"
                                    class="form-control @error('diskon') is-invalid @enderror" required>
                                @error('diskon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='stok_awal' class='mb-2'>Stok Awal</label>
                                <input type='number' name='stok_awal' id='stok_awal'
                                    class='form-control @error('stok_awal') is-invalid @enderror'
                                    value='{{ old('stok_awal') }}'>
                                @error('stok_awal')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='stok_minimal' class='mb-2'>Minimal Stok</label>
                                <input type='number' name='stok_minimal' id='stok_minimal'
                                    class='form-control @error('stok_minimal') is-invalid @enderror'
                                    value='{{ old('stok_minimal') }}'>
                                @error('stok_minimal')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telfon">Telephone</label>
                                <input type="number" name="telfon"
                                    class="form-control @error('telfon') is-invalid @enderror"
                                    placeholder="gunakan 62 tanpa +" required>
                                @error('telfon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi Barang</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" required></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="KTP">Foto Barang</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group pull-right mt-2">
                                <input type="submit" name="add" value="Tambah" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
