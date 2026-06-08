<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayoutController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payout::with('instructor')->latest();

        if ($request->filled('status')) {
            $query->where('status', (string) $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = (string) $request->string('search');

            $query->whereHas('instructor', function ($instructorQuery) use ($search) {
                $instructorQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $stats = [
            'total_amount' => Payout::sum('amount'),
            'pending' => Payout::where('status', 'pending')->count(),
            'paid' => Payout::where('status', 'paid')->count(),
            'rejected' => Payout::where('status', 'rejected')->count(),
        ];

        $payouts = $query->paginate(10)->withQueryString();
        $instructors = User::whereIn('role', ['instructor', 'admin'])
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $statusClassMap = [
            'pending'  => 'bg-yellow-100 text-yellow-700',
            'paid'     => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
        ];

        $statusLabelMap = [
            'pending'  => 'Pending',
            'paid'     => 'Success',
            'rejected' => 'Failed',
        ];

        return view('admin.payouts', compact('stats', 'payouts', 'instructors', 'statusClassMap', 'statusLabelMap'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'instructor_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string'],
        ]);

        $validated['status'] = 'pending';

        Payout::create($validated);

        return redirect()->route('admin.payouts')->with('success', 'Payout berhasil dibuat.');
    }

    public function update(Request $request, Payout $payout): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,rejected'],
            'note' => ['nullable', 'string'],
        ]);

        $validated['paid_at'] = $validated['status'] === 'paid' ? now() : null;

        $payout->update($validated);

        return redirect()->route('admin.payouts')->with('success', 'Status payout berhasil diperbarui.');
    }
}
