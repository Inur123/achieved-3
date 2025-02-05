<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil transaksi berdasarkan user yang sedang login
        $transactions = Transaction::where('user_id', Auth::id())->get();

        // Ambil data user yang sedang login
        $user = Auth::user();
        // Kirim data transaksi dan user ke view
        return view('user.transactions.index', compact('transactions', 'user'));
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
        ]);
        $product = Product::findOrFail($validated['product_id']);
        // Buat transaksi baru dengan status 'pending'
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'order_id' => 'TRX-' . time(),  // Generate order_id
            'snap_token' => null,
            'status' => 'pending',
            'price' => $product->price,
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
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $transaction->product->id,
                    'price' => $transaction->product->price,
                    'quantity' => 1,
                    'name' => $transaction->product->name,
                ]
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

        // Ambil data user yang sedang login
        $user = Auth::user();

        // Tampilkan halaman checkout dengan Snap Token, dan data user
        return view('user.transactions.checkout', compact('transaction', 'snapToken', 'user'));
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
        session()->flash('error', 'Transaksi tidak ditemukan.');
        return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
    }

    // Update the transaction status based on the Midtrans response
    switch ($request->transaction_status) {
        case 'settlement': // Payment successful
            $transaction->update(['status' => 'approved']);
            session()->flash('success', 'Pembayaran berhasil. Status transaksi telah diperbarui.');
            break;
        case 'pending': // Payment pending
            $transaction->update(['status' => 'pending']);
            session()->flash('info', 'Pembayaran masih pending.');
            break;
        case 'expire': // Payment expired
        case 'cancel': // Payment canceled
            $transaction->update(['status' => 'failed']);
            session()->flash('error', 'Pembayaran gagal atau dibatalkan.');
            break;
        default:
            session()->flash('error', 'Status transaksi tidak valid.');
            return response()->json(['status' => 'error', 'message' => 'Invalid transaction status'], 400);
    }

    // Return success response
    return response()->json(['status' => 'success', 'message' => 'Transaction status updated'], 200);
}


    public function generateInvoice($transactionId)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::with('product')->findOrFail($transactionId);

        // Buat instance dari PDF terlebih dahulu
        $pdf = app('dompdf.wrapper'); // This will get the instance of the PDF class

        // Load view untuk PDF
        $pdf->loadView('user.transactions.invoice', compact('transaction'));

        // Return PDF untuk di-stream (open in browser, allow print/download)
        return $pdf->stream('invoice-' . $transaction->order_id . '.pdf');
    }

    //destroy
    public function destroy(Transaction $transaction)
    {
        // Get the user_id from the transaction
        $userId = $transaction->user_id;

        // Menghapus transaksi
        $transaction->delete();

        // Mengarahkan kembali ke URL yang dituju setelah transaksi dihapus
        return redirect("/user/transactions")
            ->with('success', 'Transaksi berhasil dihapus.');
    }

}
