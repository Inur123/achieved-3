<!-- resources/views/admin/transaksi/show.blade.php -->
@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Detail Transaksi</h4>

                <div class="card">
                    <div class="card-body">
                        <!-- Detail Transaksi -->
                        <h5>Invoice: #{{ $transaction->order_id}}</h5>
                        <p><strong>Nama User:</strong> {{ $transaction->user->name }}</p>
                        <p><strong>Email User:</strong> {{ $transaction->user->email }}</p>
                        <p><strong>Nama Produk:</strong> {{ $transaction->product->name }}</p>
                        <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->translatedFormat('l, d F Y | H.i.s') }}</p>
                        <p><strong>Status Pembayaran:</strong>
                            @if ($transaction->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($transaction->status == 'paid')
                                <span class="badge bg-info">Paid</span>
                            @else
                                <span class="badge bg-success">Approve</span>
                            @endif
                        </p>
                        <p><strong>Total:</strong> Rp {{ number_format($transaction->price, 0, ',', '.') }}</p>


                        <a href="{{ route('admin.transaksi.detail', $transaction->user_id) }}" class="btn btn-outline-secondary">Kembali ke Daftar Transaksi</a>

                        <a href="{{ route('admin.transaksi.generateInvoice', $transaction->id) }}" class="btn btn-outline-primary">Cetak Invoice</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
