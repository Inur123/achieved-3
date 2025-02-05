<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSalesController extends Controller
{
    public function index()
    {
        // Mengambil produk dengan status true beserta total quantity yang terjual (dihitung dari product_transactions)
        $products = Product::where('status', true)
        ->get()
        ->map(function($product) {
            // Menghitung jumlah transaksi untuk produk ini di tabel transactions
            $totalSold = Transaction::where('product_id', $product->id)
                ->where('status', 'approved') // Menghitung hanya transaksi yang sudah disetujui (approved)
                ->count();  // Menghitung berapa kali produk ini terjual (berdasarkan jumlah transaksi)

            // Menambahkan total yang terjual ke dalam objek produk
            $product->total_sold = $totalSold;

            return $product;
        });

        // Pass data ke view
        return view('admin.product_sales', compact('products'));
    }
}
