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
        <h1 class="mb-3">Welcome, <span class="text-primary">{{ ucwords(strtolower($user->name)) }}</span></h1>

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
        <!-- Row 1: Total Post, Total Category, Total Author, Total Tags -->
        <div class="row">
            <h2 class="">Blog</h2>

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
            <h2>Layanan</h2>

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
        <div class="row">
            <h2 >Pengguna</h2>

            <!-- Total Users Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.user.index') }}" class="card shadow-sm text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">{{ $totalUsers }} Users</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
