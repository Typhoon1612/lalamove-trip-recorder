<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lalamove Driver Portal')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#120800] min-h-screen font-sans text-white">

    <header class="bg-[#0d0600] border-b border-orange-900/20 px-4 md:px-8 py-3">
        <div class="w-full flex items-center justify-between">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="bg-orange-500 rounded-xl p-2 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875H3.375ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875H3a3 3 0 1 0 6 0h3.75a3 3 0 1 0 6 0h.375a1.875 1.875 0 0 0 1.875-1.875v-1.5c0-1.036-.84-1.875-1.875-1.875H13.5ZM8.25 19.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm7.5 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                        <path d="M15.75 6.75a.75.75 0 0 0-.75.75v3h4.75l-1.45-2.17a.75.75 0 0 0-.63-.33H15.75Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-semibold text-sm leading-tight">Lalamove Driver Portal</p>
                    <p class="text-orange-400/60 text-xs mt-0.5">Kuala Lumpur Fleet</p>
                </div>
            </div>

            {{-- Profile avatar with dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" type="button" class="focus:outline-none">
                    <img src="https://ui-avatars.com/api/?name=Driver&background=F97316&color=fff&size=40"
                         alt="Profile"
                         class="w-10 h-10 rounded-full border-2 border-orange-500">
                </button>
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-44 bg-[#1e1008] border border-orange-900/30 rounded-xl shadow-xl py-1 z-50"
                     style="display: none;">
                    <a href="/" class="block px-4 py-2 text-sm text-orange-100/80 hover:text-orange-400 hover:bg-orange-500/10 transition-colors">Record Trip</a>
                    <a href="/trips" class="block px-4 py-2 text-sm text-orange-100/80 hover:text-orange-400 hover:bg-orange-500/10 transition-colors">Trip Logs</a>
                </div>
            </div>

        </div>
    </header>

    <main class="px-4 py-6 @yield('containerClass', 'max-w-2xl') mx-auto">
        @yield('content')
    </main>

</body>
</html>