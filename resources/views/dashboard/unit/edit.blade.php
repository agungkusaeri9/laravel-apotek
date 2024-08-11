@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Satuan</h1>
        </div>
        <div class="pull-right">
            <a href="{{ route('unit.index') }}" class="btn btn-warning btn-xs mb-4"><i
                    class="glyphicon glyphicon-chevron-left"> Kembali</i></a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('unit.update', $item->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class='form-group mb-3'>
                                <label for='nama' class='mb-2'>Nama</label>
                                <input type='text' name='nama' id='nama'
                                    class='form-control @error('nama') is-invalid @enderror'
                                    value='{{ $item->nama ?? old('nama') }}'>
                                @error('nama')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Update Satuan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
