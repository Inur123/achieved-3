<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Author;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Count of posts, categories, authors, tags
        $totalPosts = Post::where('is_published', true)->count();
        $totalCategories = Category::count();
        $totalAuthors = Author::count();
        $totalTags = Tag::count();
        $totalProducts = Product::count();
        $totalPurchasedProducts = Product::has('transactions')->count();

        // Get the total transactions
        $totalTransactions = Transaction::count();

        // Fetch all transactions and their associated products
        $transactions = Transaction::with('product')->get();

        // Calculate the total payment for products purchased in all transactions
        $totalPayments = $transactions->reduce(function ($carry, $transaction) {
            return $carry + ($transaction->product ? $transaction->product->price : 0);
        }, 0);

        return view('admin.dashboard', compact(
            'totalPosts',
            'totalCategories',
            'totalAuthors',
            'totalTags',
            'totalProducts',
            'totalPurchasedProducts',
            'totalTransactions',
            'totalPayments'

        ));
    }

    public function getProductSales()
    {
        // Get all products and count their total sales
        $products = Product::withCount('transactions')
            ->get()
            ->map(function ($product) {
                $product->total_sold = $product->transactions_count; // This is the total sales count
                return $product;
            });

        // Return the view inside the admin/products folder
        return view('admin.product_sales', compact('products'));
    }
}
