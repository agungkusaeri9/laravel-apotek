@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan Barang Masuk</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('report.product-in.print') }}" method="post">
                            @csrf
                            <div class='form-group mb-3'>
                                <label for='dari' class='mb-2'>Dari</label>
                                <input type='date' name='dari' id='dari'
                                    class='form-control @error('dari') is-invalid @enderror' value='{{ old('dari') }}'>
                                @error('dari')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class='form-group mb-3'>
                                <label for='sampai' class='mb-2'>Sampai</label>
                                <input type='date' name='sampai' id='sampai'
                                    class='form-control @error('sampai') is-invalid @enderror' value='{{ old('sampai') }}'>
                                @error('sampai')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger"><i class="fas fa-file-pdf"></i> Cetak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
