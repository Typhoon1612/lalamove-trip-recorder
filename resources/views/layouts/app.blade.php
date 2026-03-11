<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lalamove Trip Recorder</title>
    
    @vite('resources/css/app.css')
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-900">

    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="font-bold text-xl text-orange-500">Lalamove Tracker</div>

        <div x-data="{ open: false }" class="relative">
            
            <button @click="open = !open" class="focus:outline-none">
                <img src="https://ui-avatars.com/api/?name=Driver&background=F97316&color=fff" alt="Profile" class="w-10 h-10 rounded-full border-2 border-orange-500">
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 border border-gray-200" style="display: none;">
                <a href="/" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-500">Homepage</a>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-orange-500">Trip Logs</a>
            </div>
        </div>
    </nav>

    <main class="p-4 max-w-4xl mx-auto">
        @yield('content')
    </main>

</body>
</html>