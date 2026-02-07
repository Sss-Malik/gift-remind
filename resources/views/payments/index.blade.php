<x-app-layout>
    <x-slot name="header">
        Payment History
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-stone-50 text-stone-500 text-xs uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">Event</th>
                <th class="px-6 py-4">Method</th>
                <th class="px-6 py-4">Amount</th>
                <th class="px-6 py-4">Submitted</th>
                <th class="px-6 py-4">Status</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
            @forelse($payments as $payment)
                <tr class="hover:bg-stone-50/50 transition">
                    <td class="px-6 py-4 font-medium text-stone-900">
                        {{ $payment->event->title }}
                    </td>
                    <td class="px-6 py-4 text-stone-600">
                        {{ $payment->method }}
                    </td>
                    <td class="px-6 py-4 font-bold text-stone-900">
                        Rs. {{ number_format($payment->amount) }}
                    </td>
                    <td class="px-6 py-4 text-stone-500 text-sm">
                        {{ $payment->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($payment->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-bold">Pending Review</span>
                        @elseif($payment->status === 'approved')
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">Confirmed</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-bold">Rejected</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-stone-900 mb-2">No payments yet</h3>
                        <p class="text-stone-500 mb-4">Your payment history will appear here once you complete a gift purchase.</p>
                        <a href="{{ route('events.index') }}" class="text-brand-600 hover:text-brand-700 font-medium text-sm">View your events</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
