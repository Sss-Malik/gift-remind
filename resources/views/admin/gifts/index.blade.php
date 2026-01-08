<x-app-layout>
    <x-slot name="header">
        Manage Gifts
    </x-slot>

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-stone-900">Catalogue Inventory</h3>
        <a href="{{ route('admin.gifts.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition shadow-sm">
            + Add New Gift
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-stone-50 text-stone-500 text-xs uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">Image</th>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Category</th>
                <th class="px-6 py-4">Price</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
            @foreach($gifts as $gift)
                <tr class="hover:bg-stone-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="w-12 h-12 rounded-lg bg-stone-100 overflow-hidden border border-stone-200">
                            <img src="{{ $gift->image_path }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-stone-900">{{ $gift->name }}</td>
                    <td class="px-6 py-4 text-stone-600">{{ $gift->category }}</td>
                    <td class="px-6 py-4 font-bold text-stone-800">Rs. {{ number_format($gift->price) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $gift->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $gift->is_active ? 'Active' : 'Hidden' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.gifts.edit', $gift->id) }}" class="text-brand-600 hover:underline text-sm font-medium">Edit</a>

                        <form action="{{ route('admin.gifts.destroy', $gift->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $gifts->links() }}
    </div>
</x-app-layout>
