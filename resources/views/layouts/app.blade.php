<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Application')</title>
    @vite('resources/css/app.css')
</head>
<body class="flex h-full">
    <!-- Barre latérale -->
    <aside class="w-1/5 bg-gray-800 text-white p-4 h-screen">
        <h2 class="text-2xl font-bold mb-4">Menu</h2>
        <nav>
            <ul>
                <li class="mb-2"><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>

            </ul>
        </nav>
    </aside>
    <main class="container mx-auto p-4">
        @yield('content')
    </main>
</body>
</html>
