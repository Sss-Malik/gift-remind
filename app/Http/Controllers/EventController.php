<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gift;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->with(['recipient', 'gift'])
            ->orderBy('event_date', 'asc')
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        // Fetch active gifts for the selection list
        $gifts = Gift::where('is_active', true)->get();
        // Fetch existing recipients for the dropdown
        $recipients = Recipient::where('user_id', Auth::id())->get();

        return view('events.create', compact('gifts', 'recipients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'type' => 'required|in:birthday,anniversary,custom',
            'notification_days' => 'required|integer|min:1|max:30',
            // Recipient Logic: Select existing OR create new
            'recipient_id' => 'nullable|exists:recipients,id',
            'new_recipient_name' => 'required_without:recipient_id|nullable|string|max:255',
            'gift_id' => 'nullable|exists:gifts,id',
        ]);

        $user = Auth::user();

        // Handle Recipient Creation logic
        $recipientId = $request->recipient_id;
        if (!$recipientId && $request->new_recipient_name) {
            $recipient = Recipient::create([
                'user_id' => $user->id,
                'name' => $request->new_recipient_name,
                'relationship' => 'Friend' // Default
            ]);
            $recipientId = $recipient->id;
        }

        Event::create([
            'user_id' => $user->id,
            'recipient_id' => $recipientId,
            'gift_id' => $request->gift_id,
            'title' => $request->title,
            'event_date' => $request->event_date,
            'type' => $request->type,
            'notification_days' => $request->notification_days,
            'status' => 'scheduled',
        ]);

        return redirect()->route('events.index')->with('success', 'Event scheduled successfully!');
    }
}
