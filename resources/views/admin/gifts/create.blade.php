<x-app-layout>
    <x-slot name="header">
        Add New Gift
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-stone-200">
        <form method="POST" action="{{ route('admin.gifts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-sm text-stone-700 mb-1">Gift Name</label>
                <input type="text" name="name" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium text-sm text-stone-700 mb-1">Category</label>
                    <input type="text" name="category" placeholder="e.g. Electronics" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                </div>
                <div>
                    <label class="block font-medium text-sm text-stone-700 mb-1">Price (PKR)</label>
                    <input type="number" name="price" step="0.01" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-stone-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500"></textarea>
            </div>

            <div class="mb-6">
                <label class="block font-medium text-sm text-stone-700 mb-1">Gift Image</label>
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100" required>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="rounded text-brand-600 focus:ring-brand-500 border-stone-300">
                <span class="ml-2 text-sm text-stone-600">Available for purchase immediately</span>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.gifts.index') }}" class="text-stone-500 hover:text-stone-700 py-2">Cancel</a>
                <button type="submit" class="bg-brand-600 text-white px-6 py-2 rounded-lg font-bold shadow hover:bg-brand-700 transition">Save Gift</button>
            </div>
        </form>
    </div>
</x-app-layout>
