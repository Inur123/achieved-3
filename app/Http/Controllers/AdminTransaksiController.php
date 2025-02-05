<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        // Menghapus transaksi
        $transaction->delete();

        // Mengarahkan kembali dengan pesan sukses
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
