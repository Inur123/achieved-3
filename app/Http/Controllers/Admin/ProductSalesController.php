<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSalesController extends Controller
{
    public function index()
    {
        // Mengambil produk dengan status true beserta total quantity yang terjual (dihitung dari product_transactions)
        $products = Product::where('status', true)
            ->withSum('productTransactions as total_sold', 'quantity')
            ->get();

        // Pass data ke view
        return view('admin.product_sales', compact('products'));
    }
}
