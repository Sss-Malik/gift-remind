<?php

namespace App\Http\Controllers;

use App\Models\Gift;

class GiftController extends Controller
{
    public function index()
    {
        // Fetch active gifts, paginated
        $gifts = Gift::where('is_active', true)->paginate(9);

        return view('gifts.index', compact('gifts'));
    }

    public function show(Gift $gift)
    {
        abort_unless($gift->is_active, 404);

        $relatedGifts = Gift::where('is_active', true)
            ->whereKeyNot($gift->id)
            ->when($gift->category, fn ($query) => $query->where('category', $gift->category))
            ->latest()
            ->take(3)
            ->get();

        if ($relatedGifts->count() < 3) {
            $relatedGifts = Gift::where('is_active', true)
                ->whereKeyNot($gift->id)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('gifts.show', compact('gift', 'relatedGifts'));
    }
}
