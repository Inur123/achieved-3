@extends('layouts.app')

@section('title', 'Riwayat Transaksi ')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div id="toastContainer" style="position: fixed; top: 10px; right: 10px; z-index: 1050;">
        @if (session('success'))
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="container-fluid">
        <h4 class="mb-3">Riwayat Transaksi</h4>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Tanggal Transaksi</th>
                            <th>Status</th>
                            <th>Bayar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->name }}</td>
                                <td>{{ $transaction->email }}</td>
                                <td>{{ $transaction->phone_number }}</td>
                                <td>{{ $transaction->product->name }}</td>
                                <td>Rp {{ number_format($transaction->product->price, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td> <!-- Tanggal transaksi -->
                                <td>
                                    @if ($transaction->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($transaction->status == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-info">Approve</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($transaction->status == 'pending')
                                        <!-- Tombol Bayar hanya muncul jika status pending -->
                                        <a href="{{ route('transactions.checkout', ['transactionId' => $transaction->id]) }}" class="btn btn-primary btn-sm">Bayar</a>
                                    @elseif ($transaction->status == 'paid' || $transaction->status == 'approved')
                                        <!-- Status transaksi sudah dibayar -->
                                        <span class="badge bg-success">Sudah Dibayar</span>
                                    @endif
                                </td>




                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
