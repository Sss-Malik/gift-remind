<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $upcomingEvents = Event::where('user_id', $userId)
            ->where('event_date', '>=', now())
            ->whereIn('status', ['pending', 'scheduled'])
            ->count();

        $pendingPayments = Payment::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $giftsSent = Payment::where('user_id', $userId)
            ->where('status', 'approved')
            ->count();

        $recentEvents = Event::where('user_id', $userId)
            ->where('event_date', '>=', now())
            ->with('recipient')
            ->orderBy('event_date', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'upcomingEvents',
            'pendingPayments',
            'giftsSent',
            'recentEvents'
        ));
    }
}
