<!-- resources/views/admin/approved_transactions/show.blade.php -->

@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    {{-- Content --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Detail Transaksi</h4>

                <div class="card">
                    <div class="card-body">
                        <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
                        <p><strong>Nama:</strong> {{ $transaction->name }}</p>
                        <p><strong>Email:</strong> {{ $transaction->email }}</p>
                        <p><strong>Produk:</strong> {{ $transaction->product->name }}</p>
                        <p><strong>Harga:</strong> Rp {{ number_format($transaction->product->price, 0, ',', '.') }}</p>
                        <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->translatedFormat('l, d F Y | H.i.s') }}</p>

                        <p><strong>Status:</strong> {{ $transaction->status }}</p>
                        <p><strong>Catatan Approval:</strong> {{ $transaction->approval_notes }}</p>
                        <p><strong>Bukti Pembayaran:</strong>
                            <a href="{{ asset('storage/'.$transaction->payment_proof) }}" target="_blank">
                                <img src="{{ asset('storage/'.$transaction->payment_proof) }}" alt="Payment Proof" width="100">
                            </a>
                        </p>
                        @if ($transaction->status === 'pending')
                            <form action="{{ route('approved_transactions.approve', $transaction->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success">Approve</button>
                            </form>
                        @else
                            <span class="badge bg-success">Approved</span>
                        @endif


                    </div>

                </div>
                <div class="card-footer">
                    <a href="{{ route('approved_transactions.index') }}" class="btn btn-outline-secondary w-auto">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
