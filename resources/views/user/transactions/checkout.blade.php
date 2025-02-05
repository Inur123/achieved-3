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
    <h2>Checkout</h2>
    <p><strong>Produk:</strong> {{ $transaction->product->name }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($transaction->product->price, 0, ',', '.') }}</p>
    <p><strong>Nama:</strong> {{ $transaction->name }}</p>
    <p><strong>Email:</strong> {{ $transaction->email }}</p>
    <p><strong>Nomor HP:</strong> {{ $transaction->phone_number }}</p>

    <form action="{{ route('transactions.checkout', $transaction->id) }}" method="GET">
        @csrf
        <button type="button" id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Bayar Nanti</a>
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Pembayaran sukses!',
                            text: "Pembayaran Anda telah berhasil diproses.",
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.href = "{{ route('transactions.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: "Terjadi kesalahan saat memperbarui status transaksi.",
                            confirmButtonColor: '#d33'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran gagal!',
                        text: "Terjadi masalah saat memproses pembayaran.",
                        confirmButtonColor: '#d33'
                    });
                });
            },
            onPending: function(result) {
                Swal.fire({
                    icon: 'info',
                    title: 'Menunggu pembayaran...',
                    text: "Pembayaran Anda sedang diproses.",
                    confirmButtonColor: '#f39c12'
                });
            },
            onError: function(result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran gagal!',
                    text: "Terjadi masalah saat memproses pembayaran.",
                    confirmButtonColor: '#d33'
                });
            }
        });
    };
</script>

@endsection
