<x-app-layout>
    <x-slot name="header">
        Secure Checkout
    </x-slot>

    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
                <h3 class="text-lg font-bold text-stone-900 mb-4">Order Summary</h3>

                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $event->gift->image_path }}" class="w-20 h-20 object-cover rounded-lg bg-stone-100">
                    <div>
                        <p class="font-bold text-stone-900">{{ $event->gift->name }}</p>
                        <p class="text-sm text-stone-500">{{ $event->gift->category }}</p>
                    </div>
                </div>

                <div class="border-t border-stone-100 pt-4 space-y-2">
                    <div class="flex justify-between text-stone-600">
                        <span>Recipient</span>
                        <span class="font-medium text-stone-900">{{ $event->recipient->name }}</span>
                    </div>
                    <div class="flex justify-between text-stone-600">
                        <span>Delivery Date</span>
                        <span class="font-medium text-stone-900">{{ $event->event_date->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-stone-900 pt-2 border-t border-stone-100 mt-2">
                        <span>Total Amount</span>
                        <span class="text-brand-600">Rs. {{ number_format($event->gift->price) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                <h4 class="font-bold text-blue-800 mb-2">Instructions</h4>
                <ul class="text-sm text-blue-700 space-y-2 list-disc pl-4">
                    <li>Send the total amount to one of the accounts listed on the right.</li>
                    <li>Take a clear screenshot of the transaction success screen.</li>
                    <li>Upload the screenshot in the form.</li>
                    <li>Our team will verify within 24 hours.</li>
                </ul>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200 h-fit">
            <h3 class="text-lg font-bold text-stone-900 mb-6">Confirm Payment</h3>

            <form method="POST" action="{{ route('payments.store', $event->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block font-medium text-sm text-stone-700 mb-3">Select Payment Method</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="method" value="EasyPaisa" class="peer sr-only" required>
                            <div class="p-4 rounded-xl border-2 border-stone-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-stone-50 transition text-center">
                                <span class="block font-bold text-stone-800">EasyPaisa</span>
                                <span class="text-xs text-stone-500">0300-1234567</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="method" value="JazzCash" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-stone-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-stone-50 transition text-center">
                                <span class="block font-bold text-stone-800">JazzCash</span>
                                <span class="text-xs text-stone-500">0321-7654321</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-stone-700 mb-1">Transaction ID (Optional)</label>
                    <input type="text" name="transaction_reference" placeholder="e.g. TID12345678" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-sm text-stone-700 mb-1">Upload Screenshot</label>
                    <input type="file" name="proof_screenshot" accept="image/*" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100" required>
                </div>

                <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-xl font-bold shadow-md hover:bg-brand-700 transition">
                    Submit Proof
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
