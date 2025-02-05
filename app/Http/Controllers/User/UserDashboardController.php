<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->transactions;


        $totalTransactions = $transactions->count();


        $totalPayments = $transactions->reduce(function ($carry, $transaction) {
            return $carry + ($transaction->product ? $transaction->product->price : 0);
        }, 0);

        return view('user.dashboard', compact('transactions', 'totalTransactions', 'totalPayments'));
    }
}
