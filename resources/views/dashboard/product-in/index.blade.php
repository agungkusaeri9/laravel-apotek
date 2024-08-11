@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Barang Masuk</h1>
        </div>
        <div class="pull-right mb-2">
            <a href="{{ route('product-in.create') }}" class="btn btn-success btn-xs"><i>Tambah Barang Masuk</i></a>
        </div>

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
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th>Pemilik</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Stok Akhir</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $item->created_at->translatedFormat('d/m/Y') }}</td>
                                            <td>{{ $item->product->nama }}</td>
                                            <td>
                                                {{ $item->product->user->name }}
                                            </td>
                                            <td>{{ $item->product->description }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>{{ $item->product->stok }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                <a href="{{ route('product-in.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('product-in.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-sm btn-danger show_confirm"
                                                        data-toggle="tooltip" title='Delete'>Delete</button>
                                                    {{-- <button type="submit" class="btn btn-sm btn-danger">Delete</button> --}}
                                                </form>
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
