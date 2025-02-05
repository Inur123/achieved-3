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



    public function callback(Request $request)
{
    $serverKey = config('midtrans.server_key');
    $signatureKey = $request->input('signature_key');
    $orderId = $request->input('order_id');
    $transactionStatus = $request->input('transaction_status');
    $statusCode = $request->input('status_code');
    $grossAmount = $request->input('gross_amount');

    // Generate expected signature
    $expectedSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

    // Verify the signature
    if ($signatureKey !== $expectedSignature) {
        return response()->json(['message' => 'Invalid signature'], 403);
    }

    // Find the transaction in the database
    $transaction = Transaction::where('order_id', $orderId)->first();

    if (!$transaction) {
        return response()->json(['message' => 'Transaction not found'], 404);
    }

    // Update the transaction status based on the payment status
    if ($transactionStatus == 'settlement') {
        $transaction->update(['status' => 'approved']);
    } elseif ($transactionStatus == 'pending') {
        $transaction->update(['status' => 'pending']);
    } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel') {
        $transaction->update(['status' => 'failed']);
    }

    // Optionally, log the status or send additional data
    return response()->json(['message' => 'Transaction status updated'], 200);
}

}
