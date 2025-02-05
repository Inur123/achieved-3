<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\ApprovedTransaction;
use Illuminate\Http\Request;

class ApprovedTransactionController extends Controller
{
    // Menampilkan transaksi yang sudah disetujui
    public function index()
{
    // Ambil semua transaksi dari tabel transactions
    $transactions = Transaction::with('product')->get(); // Ambil semua transaksi dan produk terkait

    // Kirimkan variabel transactions ke tampilan
    return view('admin.approved_transactions.index', compact('transactions'));
}

public function approve($id)
{
    // Cek apakah pengguna yang sedang login memiliki role ID 1 (admin)
    if (auth()->user()->role->id != 1) {
        // Jika bukan admin, redirect kembali dengan pesan error
        return redirect()->route('home')->with('error', 'You do not have permission to approve transactions.');
    }

    // Temukan transaksi berdasarkan ID
    $transaction = Transaction::findOrFail($id);

    // Simpan transaksi yang disetujui ke tabel approved_transactions
    $approvedTransaction = ApprovedTransaction::create([
        'transaction_id' => $transaction->id,
        'approval_notes' => 'Approved by admin', // Catatan approval bisa disesuaikan
    ]);

    // Update status transaksi menjadi 'approved'
    $transaction->status = 'approved';
    $transaction->save();

    // Redirect ke halaman daftar transaksi dengan pesan sukses
    return redirect()->route('approved_transactions.index')->with('success', 'Transaksi telah disetujui.');
}

    // Menghapus transaksi yang sudah disetujui
    public function destroy($id)
    {
        // Menemukan transaksi yang sudah disetujui berdasarkan ID
        $approvedTransaction = ApprovedTransaction::findOrFail($id);

        // Menghapus approved transaction
        $approvedTransaction->delete();

        // Mengubah status transaksi kembali ke 'pending'
        $transaction = $approvedTransaction->transaction;
        $transaction->status = 'pending';
        $transaction->save();

        return redirect()->route('approved_transactions.index')->with('success', 'Transaksi berhasil dihapus dari daftar approved.');
    }

    public function show($id)
{
    // Ambil data transaksi berdasarkan ID
    $transaction = Transaction::findOrFail($id);

    // Kirimkan data transaksi ke tampilan
    return view('admin.approved_transactions.show', compact('transaction'));
}
}
