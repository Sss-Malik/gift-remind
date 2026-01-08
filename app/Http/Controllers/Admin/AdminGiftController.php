<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gifts = Gift::latest()->paginate(10);
        return view('admin.gifts.index', compact('gifts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048', // Max 2MB
            'is_active' => 'boolean'
        ]);

        $path = $request->file('image')->store('gifts', 'public');

        Gift::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image_path' => Storage::url($path), // Store public URL or relative path
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.gifts.index')->with('success', 'Gift added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gift $gift)
    {
        return view('admin.gifts.edit', compact('gift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gift $gift)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['name', 'category', 'price', 'description']);
        $data['is_active'] = $request->boolean('is_active');

        // Handle Image Update
        if ($request->hasFile('image')) {
            // Optional: Delete old image to save space
            // Storage::disk('public')->delete(str_replace('/storage/', '', $gift->image_path));

            $path = $request->file('image')->store('gifts', 'public');
            $data['image_path'] = Storage::url($path);
        }

        $gift->update($data);

        return redirect()->route('admin.gifts.index')->with('success', 'Gift updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gift $gift)
    {
        // Check if gift is used in events? If so, maybe soft delete or block.
        // For MVP, we will allow deletion but standard practice is soft-deletes.

        $gift->delete();
        return redirect()->route('admin.gifts.index')->with('success', 'Gift removed.');
    }
}
