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
        <!-- Row 1: Total Post, Total Category, Total Author, Total Tags -->
        <div class="row">
            <h1 class="fs-7">Blog</h1>

            <!-- Total Posts Card -->
            <div class="col-md-3">
                <a href="{{ route('blog.posts.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Posts</h5>
                        <p class="card-text">{{ $totalPosts }} Posts</p>
                    </div>
                </a>
            </div>

            <!-- Total Categories Card -->
            <div class="col-md-3">
                <a href="{{ route('blog.categories.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Categories</h5>
                        <p class="card-text">{{ $totalCategories }} Categories</p>
                    </div>
                </a>
            </div>

            <!-- Total Authors Card -->
            <div class="col-md-3">
                <a href="{{ route('blog.authors.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Authors</h5>
                        <p class="card-text">{{ $totalAuthors }} Authors</p>
                    </div>
                </a>
            </div>

            <!-- Total Tags Card -->
            <div class="col-md-3">
                <a href="{{ route('blog.tags.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Tags</h5>
                        <p class="card-text">{{ $totalTags }} Tags</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Row 2: Total Product, Total Transactions, Total Payments -->
        <div class="row">
            <h1 class="fs-7">Layanan</h1>

            <!-- Total Products Card -->
            <div class="col-md-4">
                <a href="{{ route('products.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text">{{ $totalProducts }} Products</p>
                    </div>
                </a>
            </div>

            <!-- Total Transactions Card -->
            <div class="col-md-4">
                <a href="{{ url('/admin/transaksi') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Transactions</h5>
                        <p class="card-text">{{ number_format($totalTransactions) }} Transactions</p>
                    </div>
                </a>
            </div>


            <!-- Total Payments Card -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Payments</h5>
                        <p class="card-text">Rp {{ number_format($totalPayments, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
