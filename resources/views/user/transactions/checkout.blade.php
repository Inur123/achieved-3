@extends('layouts.app')

@section('title', 'Checkout')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="container-fluid">
    <h2>Checkout</h2>
    <p><strong>Produk:</strong> {{ $transaction->product->name }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($transaction->product->price, 0, ',', '.') }}</p>
    <p><strong>Nama:</strong> {{ $transaction->name }}</p>
    <p><strong>Email:</strong> {{ $transaction->email }}</p>
    <p><strong>Nomor HP:</strong> {{ $transaction->phone_number }}</p>

    <form action="{{ route('transactions.checkout', $transaction->id) }}" method="GET">
        @csrf
        <button type="button" id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function() {
        snap.pay("{{ $transaction->snap_token }}", {
            onSuccess: function(result) {
                // After success, call the backend to update the status
                fetch("{{ route('transactions.update-status') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: result.order_id,
                        transaction_status: result.transaction_status,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert("Pembayaran sukses!");
                        window.location.href = "{{ route('transactions.index') }}";
                    } else {
                        alert("Terjadi kesalahan saat memperbarui status transaksi.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Pembayaran gagal!");
                });
            },
            onPending: function(result) {
                alert("Menunggu pembayaran...");
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
            }
        });
    };
</script>
@endsection
