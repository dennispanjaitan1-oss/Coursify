<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'items.course']);

        if ($request->filled('search')) {
            $query->where('transaction_id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total'    => Payment::count(),
            'paid'     => Payment::where('status', 'paid')->count(),
            'pending'  => Payment::where('status', 'pending')->count(),
            'failed'   => Payment::where('status', 'failed')->count(),
            'revenue'  => Payment::where('status', 'paid')->sum('amount'),
        ];

        return view('admin.transactiton', compact('transactions', 'stats'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.transactions')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}