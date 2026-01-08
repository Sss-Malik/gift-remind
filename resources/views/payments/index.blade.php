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
                    <td colspan="5" class="px-6 py-8 text-center text-stone-500">
                        No payment history found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
