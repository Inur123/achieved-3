<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Models\Transaction;
use Illuminate\Http\Request;


class AdminTransaksiController extends Controller
{
    public function index()
    {
        // Mengambil semua pengguna dengan role 2 yang memiliki transaksi
        $users = User::where('role_id', 2) // Memastikan hanya pengguna dengan role 2
            ->whereHas('transactions') // Memastikan hanya pengguna yang memiliki transaksi
            ->with('transactions') // Memuat transaksi terkait
            ->get();

        // Mengirim data pengguna dan transaksi ke view
        return view('admin.transaksi.index', compact('users'));
    }

    public function showDetail($userId)
    {
        // Mengambil data transaksi berdasarkan user_id
        $transactions = Transaction::where('user_id', $userId)->get();

        // Mengambil data pengguna
        $user = User::find($userId);

        // Mengirim data transaksi dan pengguna ke view
        return view('admin.transaksi.detail', compact('transactions', 'user'));
    }

    public function destroy(Transaction $transaction)
    {
        // Get the user_id from the transaction
        $userId = $transaction->user_id;

        // Menghapus transaksi
        $transaction->delete();

        // Mengarahkan kembali ke URL yang dituju setelah transaksi dihapus
        return redirect("/admin/transaksi/{$userId}/detail")
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    // TransactionController.php
    public function show($transactionId)
    {
        // Mendapatkan detail transaksi berdasarkan ID, termasuk data produk
        $transaction = Transaction::with('product', 'user')->findOrFail($transactionId);

        // Menampilkan halaman detail transaksi dan mengirim data transaksi serta user
        return view('admin.transaksi.show', compact('transaction'));
    }


    public function generateInvoice($transactionId)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::with('product')->findOrFail($transactionId);

        // Buat instance dari PDF terlebih dahulu
        $pdf = app('dompdf.wrapper'); // This will get the instance of the PDF class

        // Load view untuk PDF
        $pdf->loadView('admin.transaksi.invoice', compact('transaction'));

        // Return PDF untuk di-stream (open in browser, allow print/download)
        return $pdf->stream('invoice-' . $transaction->order_id . '.pdf');
    }



}
