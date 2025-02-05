<!-- resources/views/admin/product_sales.blade.php -->
@extends('layouts.app')
@section('title', 'Daftar Transaksi')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('header')
    @include('layouts.header')
@endsection
@section('content')
    <div class="container-fluid ">
        <h1>Product Sales</h1>
        <div class="card">
            <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->total_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            </div>
        </div>
    </div>
@endsection
