<!-- resources/views/admin/products/product_sales.blade.php -->
@extends('layouts.app')

@section('title', 'Product Sales')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Product Sales</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Total Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->total_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
