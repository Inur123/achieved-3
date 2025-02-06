@extends('layouts.app')
@section('title', 'Daftar Transaksi')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    {{-- Toast Notification --}}
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33'
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6'
        });
    </script>
@endif


    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Daftar Detail Transaksi, <span class="text-primary">{{ ucfirst($user->name) }}</span></h4>



                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="multi_col_order" class="table table-striped table-bordered display no-wrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Status Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>


                                            <td>{{ $transaction->product->name }}</td>
                                            <td>{{ $transaction->created_at->translatedFormat('l, d F Y | H.i.s') }}</td>
                                            <td>
                                                @if ($transaction->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif ($transaction->status == 'paid')
                                                    <span class="badge bg-info">Paid</span>
                                                @else
                                                    <span class="badge bg-success">Approve</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <form action="{{ route('admin.transaksi.destroy', $transaction->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $transaction->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-outline-danger btn-sm me-2" onclick="confirmDelete({{ $transaction->id }})">Hapus</button>
                                                    </form>
                                                    <a href="{{ route('admin.transaksi.show', $transaction->id) }}" class="btn btn-outline-info btn-sm">Detail</a>
                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">Kembali ke Daftar Pengguna</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
