@extends('layouts.dashboard.layout')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data User Checkout</h1>

        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Check</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->created_at->translatedFormat('d/m/Y') }}</td>
                                            <td>{{ $user->user->name }}</td>
                                            <td>{{ $user->user->email }}</td>
                                            <td>Rp. {{ number_format($user->total, 2) }}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                {{-- <a href="#" class="btn btn-sm btn-danger">Delete</a></td> --}}
                                                @if ($user->status == 1)
                                                    <span class="badge bg-success text-white">Terbayar</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Belum Terbayar</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('payment.showUser', $user->id) }}"
                                                    class="btn btn-primary">Lihat</a>
                                            </td>
                                            <td>
                                                @if ($user->status != 1)
                                                    <form action="{{ route('payment.change', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-warning text-dark">Change</button>
                                                    </form>
                                                @else
                                                    -
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
@endsection
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
