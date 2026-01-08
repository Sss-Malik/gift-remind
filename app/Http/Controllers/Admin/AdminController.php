<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'active_events' => Event::where('event_date', '>=', now())->count(),
            'total_revenue' => Payment::where('status', 'approved')->sum('amount'),
        ];

        // Recent pending payments for quick access
        $recentPayments = Payment::with(['user', 'event.gift'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPayments'));
    }

    public function payments()
    {
        $payments = Payment::with(['user', 'event.gift'])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')") // Pending first
            ->latest()
            ->paginate(15);

        return view('admin.payments', compact('payments'));
    }

    public function approvePayment(Payment $payment)
    {
        $payment->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Optional: Notify user via email here

        return back()->with('success', 'Payment approved successfully.');
    }

    public function rejectPayment(Payment $payment)
    {
        $payment->update(['status' => 'rejected']);

        // Optional: Reset event status or notify user

        return back()->with('error', 'Payment rejected.');
    }
}
