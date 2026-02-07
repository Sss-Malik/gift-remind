<x-guest-layout>
    <section class="relative pt-16 pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">

            <div class="space-y-8 relative z-10">
                <div class="inline-block bg-brand-50 text-brand-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-2 border border-brand-100">
                    Now in Early Access
                </div>
                <h1 class="text-5xl md:text-6xl font-extrabold text-stone-900 leading-[1.1]">
                    Never Miss a <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-500">
                        Special Moment.
                    </span>
                </h1>
                <p class="text-lg text-stone-600 max-w-lg leading-relaxed">
                    GiftSync helps you plan, schedule, and send the perfect gift for every occasion. Smart reminders, AI-powered suggestions, and seamless payments — all in one place.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center bg-brand-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:bg-brand-700 hover:shadow-brand-500/30 transition-all transform hover:-translate-y-1">
                        Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center bg-white text-stone-700 border border-stone-200 px-8 py-4 rounded-xl font-semibold hover:bg-stone-50 transition">
                        Sign In
                    </a>
                </div>

                <div class="pt-8 flex items-center gap-4 text-sm text-stone-500">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-brand-200 border-2 border-white flex items-center justify-center text-xs font-bold text-brand-700">A</div>
                        <div class="w-8 h-8 rounded-full bg-blue-200 border-2 border-white flex items-center justify-center text-xs font-bold text-blue-700">S</div>
                        <div class="w-8 h-8 rounded-full bg-green-200 border-2 border-white flex items-center justify-center text-xs font-bold text-green-700">M</div>
                    </div>
                    <p>Trusted by 500+ users for gifting made easy.</p>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="absolute inset-0 bg-brand-600 blur-[100px] opacity-20 rounded-full"></div>
                <div class="relative bg-white/80 backdrop-blur-xl border border-white/50 p-6 rounded-3xl shadow-2xl rotate-[-2deg] transform hover:rotate-0 transition duration-500">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 text-xl">🎂</div>
                        <div>
                            <h3 class="font-bold text-stone-900">Mom's Birthday</h3>
                            <p class="text-xs text-stone-500">In 3 days &middot; Gift selected</p>
                        </div>
                        <div class="ml-auto bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Scheduled</div>
                    </div>
                    <div class="h-2 w-full bg-stone-100 rounded-full mb-2">
                        <div class="h-2 w-4/5 bg-gradient-to-r from-brand-500 to-brand-600 rounded-full"></div>
                    </div>
                    <p class="text-xs text-stone-400">Payment confirmed — gift on the way!</p>

                    <div class="mt-4 pt-4 border-t border-stone-100 flex items-center gap-4">
                        <div class="w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center text-brand-600 text-lg">🎁</div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-stone-800">Premium Flower Bouquet</p>
                            <p class="text-xs text-stone-500">Rs. 5,000</p>
                        </div>
                        <span class="text-green-600 text-xs font-bold">Paid</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-stone-900 mb-4">Everything you need to manage gifts</h2>
                <p class="text-stone-500">From reminders to delivery — GiftSync handles it all so you can focus on what matters.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 bg-stone-50 rounded-2xl hover:bg-brand-50/50 transition border border-stone-100">
                    <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 mb-2">Smart Scheduling</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Add birthdays, anniversaries, or custom events. Get timely reminders via email so you never miss a date.
                    </p>
                </div>

                <div class="p-8 bg-stone-50 rounded-2xl hover:bg-brand-50/50 transition border border-stone-100">
                    <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 mb-2">AI Gift Suggestions</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Not sure what to get? Our AI recommends thoughtful, personalized gifts based on the recipient and occasion.
                    </p>
                </div>

                <div class="p-8 bg-stone-50 rounded-2xl hover:bg-brand-50/50 transition border border-stone-100">
                    <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-stone-900 mb-2">Secure Payments</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Pay via EasyPaisa or JazzCash with simple screenshot verification. Fast, safe, and hassle-free.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works section --}}
    <section class="py-24 bg-stone-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-stone-900 mb-4">How GiftSync Works</h2>
                <p class="text-stone-500">Three simple steps to make someone's day special.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold">1</div>
                    <h3 class="text-lg font-bold text-stone-900 mb-2">Add Your Events</h3>
                    <p class="text-stone-500">Enter birthdays, anniversaries, or any special dates for people you care about.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold">2</div>
                    <h3 class="text-lg font-bold text-stone-900 mb-2">Pick a Gift</h3>
                    <p class="text-stone-500">Browse our catalogue or get AI-powered suggestions tailored to each recipient.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold">3</div>
                    <h3 class="text-lg font-bold text-stone-900 mb-2">Pay & Relax</h3>
                    <p class="text-stone-500">Complete payment securely and let us handle the rest. You'll be notified every step of the way.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('register') }}" class="inline-flex items-center bg-brand-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:bg-brand-700 transition-all transform hover:-translate-y-1">
                    Create Your Free Account
                </a>
            </div>
        </div>
    </section>
</x-guest-layout>
