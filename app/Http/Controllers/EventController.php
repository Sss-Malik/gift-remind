<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gift;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function create(Request $request)
    {
        // Fetch active gifts for the selection list
        $gifts = Gift::where('is_active', true)->get();
        // Fetch existing recipients for the dropdown
        $recipients = Recipient::where('user_id', Auth::id())->get();
        $minEventDate = now()->addDays(7)->toDateString();
        $aiSuggestions = collect();

        if ($request->boolean('suggest_gifts')) {
            $request->validate([
                'ai_recipient_type' => ['required', 'string', Rule::in(['mother', 'father', 'partner', 'friend', 'sibling', 'colleague'])],
                'ai_budget' => ['required', 'string', Rule::in(['under_1000', '1000_3000', '3000_5000', '5000_10000', 'above_10000'])],
                'ai_interests' => ['nullable', 'string', 'max:500'],
                'type' => ['nullable', 'string', Rule::in(['birthday', 'anniversary', 'custom'])],
            ], [], [
                'ai_recipient_type' => 'recipient type',
                'ai_budget' => 'budget',
                'ai_interests' => 'interests',
            ]);

            $rawSuggestions = app(AiSuggestionController::class)->generateSuggestions(
                $request->input('ai_recipient_type'),
                $request->input('type', 'custom'),
                $request->input('ai_budget'),
                $request->input('ai_interests', '')
            );

            $aiSuggestions = $this->matchSuggestionsToCatalogue($gifts, $rawSuggestions);
        }

        return view('events.create', compact('gifts', 'recipients', 'minEventDate', 'aiSuggestions'));
    }

    public function store(Request $request)
    {
        $minEventDate = now()->addDays(7)->toDateString();

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after_or_equal:'.$minEventDate],
            'type' => ['required', Rule::in(['birthday', 'anniversary', 'custom'])],
            'notification_days' => ['required', 'integer', 'min:7', 'max:30'],
            // Recipient Logic: Select existing OR create new
            'recipient_id' => [
                'nullable',
                Rule::exists('recipients', 'id')->where('user_id', Auth::id()),
            ],
            'new_recipient_name' => ['required_without:recipient_id', 'nullable', 'string', 'max:255'],
            'gift_id' => [
                'nullable',
                Rule::exists('gifts', 'id')->where('is_active', true),
            ],
        ], [
            'event_date.after_or_equal' => 'Events must be scheduled at least 7 days in advance.',
            'notification_days.min' => 'Reminders must be scheduled at least 7 days before the event.',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (
                $validator->errors()->has('event_date')
                || $validator->errors()->has('notification_days')
                || ! $request->filled(['event_date', 'notification_days'])
            ) {
                return;
            }

            $daysUntilEvent = now()
                ->startOfDay()
                ->diffInDays($request->date('event_date')->startOfDay(), false);

            if ((int) $request->notification_days > $daysUntilEvent) {
                $validator->errors()->add(
                    'notification_days',
                    'Reminder days cannot be greater than the days remaining before the event.'
                );
            }
        });

        $validator->validate();

        $user = Auth::user();

        // Handle Recipient Creation logic
        $recipientId = $request->recipient_id;
        if (! $recipientId && $request->new_recipient_name) {
            $recipient = Recipient::create([
                'user_id' => $user->id,
                'name' => $request->new_recipient_name,
                'relationship' => 'Friend', // Default
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

    private function matchSuggestionsToCatalogue($gifts, array $suggestions)
    {
        $usedGiftIds = [];

        return collect($suggestions)
            ->map(function (array $suggestion) use ($gifts, &$usedGiftIds) {
                $gift = $this->findSuggestedGift($gifts, $suggestion, $usedGiftIds);

                if (! $gift) {
                    return null;
                }

                $usedGiftIds[] = $gift->id;

                return [
                    'gift' => $gift,
                    'reason' => $suggestion['reason'],
                    'occasion_note' => $suggestion['occasion_note'] ?? null,
                    'matched_name' => $suggestion['name'],
                ];
            })
            ->filter()
            ->values();
    }

    private function findSuggestedGift($gifts, array $suggestion, array $usedGiftIds)
    {
        $suggestedName = strtolower($suggestion['name']);
        $suggestedCategory = strtolower($suggestion['category'] ?? '');

        $matches = [
            fn ($gift) => strtolower($gift->name) === $suggestedName,
            fn ($gift) => strtolower($gift->category ?? '') === $suggestedCategory,
            fn ($gift) => str_contains($suggestedName, strtolower($gift->name))
                || str_contains(strtolower($gift->name), $suggestedName),
        ];

        foreach ($matches as $matchesGift) {
            $gift = $gifts->first(function ($gift) use ($usedGiftIds, $matchesGift) {
                return ! in_array($gift->id, $usedGiftIds, true) && $matchesGift($gift);
            });

            if ($gift) {
                return $gift;
            }
        }

        return null;
    }
}
