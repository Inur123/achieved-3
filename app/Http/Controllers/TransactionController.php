<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;

use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil transaksi berdasarkan user yang sedang login
        $transactions = Transaction::where('user_id', auth()->id())->get();

        return view('user.transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Ambil semua produk yang tersedia
        $products = Product::where('status', true)->get();
        return view('user.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form transaksi
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        // Buat transaksi baru dengan status 'pending'
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'order_id' => 'TRX-' . time(),  // Generate order_id
            'snap_token' => null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'status' => 'pending',
        ]);

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$clientKey = config('midtrans.client_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Data untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => $transaction->product->price, // Sesuaikan dengan harga produk
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone_number,
            ],
        ];

        // Generate Snap Token
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            // Update transaksi dengan Snap Token yang di-generate
            $transaction->update(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->route('transactions.index')->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }

        // Tambah atau perbarui quantity di tabel product_transaction
        $productTransaction = ProductTransaction::where('product_id', $validated['product_id'])
            ->latest()
            ->first();

        if ($productTransaction) {
            $productTransaction->increment('quantity');
        } else {
            ProductTransaction::create([
                'product_id' => $validated['product_id'],
                'transaction_id' => $transaction->id,
                'quantity' => 1,
            ]);
        }

        // Redirect ke halaman checkout setelah transaksi berhasil dibuat
        return redirect()->route('transactions.checkout', ['transactionId' => $transaction->id]);
    }




    public function checkout($transactionId)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::with('product')->findOrFail($transactionId);

        // Pastikan Snap Token sudah ada di transaksi
        $snapToken = $transaction->snap_token;

        // Jika Snap Token tidak ada, tampilkan error
        if (!$snapToken) {
            return redirect()->route('transactions.index')->with('error', 'Snap Token tidak ditemukan. Mohon coba lagi.');
        }

        // Tampilkan halaman checkout dengan Snap Token
        return view('user.transactions.checkout', compact('transaction', 'snapToken'));
    }





    public function updateStatus(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'order_id' => 'required|string',
            'transaction_status' => 'required|string',
        ]);

        // Retrieve the transaction based on the order_id
        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        // Update the transaction status based on the Midtrans response
        switch ($request->transaction_status) {
            case 'settlement': // Payment successful
                $transaction->update(['status' => 'approved']);
                break;
            case 'pending': // Payment pending
                $transaction->update(['status' => 'pending']);
                break;
            case 'expire': // Payment expired
            case 'cancel': // Payment canceled
                $transaction->update(['status' => 'failed']);
                break;
            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid transaction status'], 400);
        }

        // Return success response
        return response()->json(['status' => 'success', 'message' => 'Transaction status updated'], 200);
    }
}
