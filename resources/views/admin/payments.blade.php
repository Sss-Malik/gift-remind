<x-app-layout>
    <x-slot name="header">
        Payment Approvals
    </x-slot>

    <div class="space-y-6">
        @foreach($payments as $payment)
            <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden flex flex-col md:flex-row">

                <div class="md:w-1/3 bg-stone-100 relative group cursor-pointer" onclick="window.open('{{ Storage::url($payment->proof_path) }}', '_blank')">
                    <img src="{{ Storage::url($payment->proof_path) }}" class="w-full h-48 md:h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <span class="text-white font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        View Full Proof
                    </span>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-stone-900">Rs. {{ number_format($payment->amount) }}</h4>
                                <p class="text-sm text-stone-500">via {{ $payment->method }}</p>
                            </div>

                            @if($payment->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-bold">Pending</span>
                            @elseif($payment->status === 'approved')
                                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold">Approved</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold">Rejected</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm text-stone-600 mb-6">
                            <div>
                                <span class="block text-xs text-stone-400 uppercase">User</span>
                                {{ $payment->user->name }}
                            </div>
                            <div>
                                <span class="block text-xs text-stone-400 uppercase">Transaction ID</span>
                                {{ $payment->transaction_reference ?? 'N/A' }}
                            </div>
                            <div>
                                <span class="block text-xs text-stone-400 uppercase">Event</span>
                                {{ $payment->event->title }}
                            </div>
                            <div>
                                <span class="block text-xs text-stone-400 uppercase">Date</span>
                                {{ $payment->created_at->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                    @if($payment->status === 'pending')
                        <div class="flex gap-4 border-t border-stone-100 pt-4">
                            <form method="POST" action="{{ route('admin.payments.approve', $payment->id) }}" class="flex-1">
                                @csrf
                                <button class="w-full bg-stone-900 text-white py-2 rounded-lg font-medium hover:bg-stone-800 transition">
                                    Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}" class="flex-1">
                                @csrf
                                <button class="w-full bg-white border border-stone-200 text-stone-600 py-2 rounded-lg font-medium hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
