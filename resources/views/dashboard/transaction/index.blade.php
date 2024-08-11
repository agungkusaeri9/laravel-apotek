@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
        </div>
        <div class="pull-right mb-2">
            <a href="{{ route('transaksi.create') }}" class="btn btn-success btn-xs"><i>Tambah Transaksi</i></a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table dtTable table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Invoice</th>
                                        <th>Sub Total</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                        <th>Tunai</th>
                                        <th>Kembalian</th>
                                        <th>Created</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->invoice }}</td>
                                            <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->diskon, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->tunai, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                <a href="{{ route('transaksi.show', $item->invoice) }}"
                                                    class="btn btn-sm py-2 btn-warning">Detail</a>
                                            </td>
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
