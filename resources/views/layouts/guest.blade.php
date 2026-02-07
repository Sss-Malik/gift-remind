<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GiftSync — Never Miss a Special Moment</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-canvas text-stone-700 flex flex-col min-h-screen">

    <nav class="w-full py-6 px-6 md:px-12 flex justify-between items-center max-w-7xl mx-auto">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-brand-600 rounded-lg shadow-lg rotate-3"></div>
            <span class="text-xl font-bold tracking-tight text-stone-900">Gift<span class="text-brand-600">Sync</span></span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition">Home</a>
            <div class="flex items-center gap-4 ml-4">
                <a href="{{ route('login') }}" class="text-stone-600 hover:text-stone-900 transition">Log in</a>
                <a href="{{ route('register') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-full shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Get Started
                </a>
            </div>
        </div>

        <button class="md:hidden text-stone-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </nav>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-stone-100 border-t border-stone-200 mt-20 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center md:text-left md:flex justify-between items-center">
            <div class="mb-4 md:mb-0">
                <p class="text-sm text-stone-500">&copy; {{ date('Y') }} GiftSync. All rights reserved.</p>
            </div>
            <div class="flex gap-6 justify-center md:justify-end text-stone-400">
                <a href="#" class="hover:text-brand-600 transition">Privacy</a>
                <a href="#" class="hover:text-brand-600 transition">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>
