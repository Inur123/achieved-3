@extends('layouts.app')

@section('title', 'Dashboard')

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

        <!-- Row 1 -->
        <div class="row">

            <h1 class="mb-3">Welcome, <span class="text-primary">{{ ucwords(strtolower(Auth::user()->name)) }}!</span></h1>

            <div class="col-md-4">
                <a href="{{ route('transactions.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Transactions</h5>
                        <p class="card-text">{{ number_format($totalTransactions) }} Transactions</p>
                    </div>
                </a>
            </div>

            <!-- Total Payments Card -->
            <div class="col-md-4">
                <a href="{{ route('transactions.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Payments</h5>
                        <p class="card-text">Rp {{ number_format($totalPayments, 0, ',', '.') }}</p>
                    </div>
                </a>
            </div>
            <!-- Placeholder Card (can be replaced later) -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Placeholder</h5>
                        <p class="card-text">This section can be used for future data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
