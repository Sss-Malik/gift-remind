<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Show Payment History
    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with('event.gift')
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('payments'));
    }

    // Show Checkout Page for a specific Event
    public function create(Event $event)
    {
        // Security: Ensure user owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        // Security: Ensure event has a gift assigned
        if (!$event->gift) {
            return redirect()->route('events.index')->with('error', 'Please assign a gift first.');
        }

        // Security: Ensure not already paid
        if ($event->payment) {
            return redirect()->route('payments.index')->with('info', 'Payment already submitted for this event.');
        }

        return view('payments.create', compact('event'));
    }

    // Process the Upload
    public function store(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) abort(403);

        $request->validate([
            'method' => 'required|in:EasyPaisa,JazzCash',
            'transaction_reference' => 'nullable|string',
            'proof_screenshot' => 'required|image|max:2048', // Max 2MB
        ]);

        // Handle File Upload
        $path = $request->file('proof_screenshot')->store('payment_proofs', 'public');

        Payment::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'amount' => $event->gift->price,
            'method' => $request->method,
            'transaction_reference' => $request->transaction_reference,
            'proof_path' => $path,
            'status' => 'pending'
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment proof uploaded! Waiting for admin approval.');
    }
}
