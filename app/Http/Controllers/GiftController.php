<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index()
    {
        // Fetch active gifts, paginated
        $gifts = Gift::where('is_active', true)->paginate(9);

        return view('gifts.index', compact('gifts'));
    }
}
