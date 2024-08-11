@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
        </div>
        @if (auth()->user()->role_id == 1)
            <div class="pull-right mb-2">
                <a href="{{ route('product.create') }}" class="btn btn-success btn-xs"><i>Tambah Barang</i></a>
            </div>
        @endif

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Pemilik</th>
                                        <th>Stok Minimal</th>
                                        <th>Stok</th>
                                        <th>Harga Diskon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $product->nama }}</td>
                                            <td>{{ $product->category->nama }}</td>
                                            <td>{{ $product->unit->nama ?? '-' }}</td>
                                            <td>Rp {{ $product->harga }}</td>
                                            <td>
                                                {{ $product->user->name }}
                                            </td>
                                            <td>{{ $product->stok_minimal }}</td>
                                            <td>
                                                @if ($product->stok_minimal < $product->stok)
                                                    {{ $product->stok }}
                                                @else
                                                    <span class="badge badge-warning">{{ $product->stok }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->diskon }}</td>
                                            <td>
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    class="btn btn-sm btn-info">Show</a>
                                                @if (auth()->user()->role_id == 1)
                                                    <a href="{{ route('product.edit', $product->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('product.destroy', $product->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                                            data-toggle="tooltip" title='Delete'>Delete</button>
                                                        {{-- <button type="submit" class="btn btn-sm btn-danger">Delete</button> --}}
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <br>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script>
            $(function() {
                $('#dataTable').DataTable();
            })
        </script>
        <script type="text/javascript">
            $('.show_confirm').click(function(event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                        title: `Are you sure you want to delete this record? `,
                        text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
        </script>
    @endpush
@endsection
