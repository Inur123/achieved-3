@extends('layouts.app')

@section('title', 'Buat Transaksi')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container-fluid">
        <h4 class="mb-3">Daftar Product</h4>

            <div class="card-body">
                <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Card to display products -->
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-3">
                                <!-- Added border class to the card -->
                                <div class="card border border-primary">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                        <button type="submit" class="btn btn-primary w-100" name="product_id" value="{{ $product->id }}">
                                            Beli Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>

    </div>
@endsection
