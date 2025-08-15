<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title', 'Espace étudiant')</title>
</head>
<body x-data="{ sidebarOpen: false }" class="flex flex-col min-h-screen md:flex-row bg-gray-100">
    <!-- Bouton menu mobile -->
    <button
    @click="sidebarOpen = !sidebarOpen"
    x-show="!sidebarOpen"
    class="md:hidden fixed top-4 left-4 z-50 bg-[#101010] p-2 rounded-lg text-white shadow"
    aria-label="Ouvrir le menu">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
</button>
    <!-- Barre latérale -->
    <aside class="fixed top-0 left-0 h-full w-64 bg-[#101010] text-white z-40 p-4 flex-shrink-0 transition-transform duration-300
           md:relative md:h-auto md:w-1/5 md:min-h-screen md:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <h2 class="text-2xl font-bold mb-4 flex justify-between items-center">
            Menu
            <button @click="sidebarOpen = false" class="md:hidden text-white text-2xl">&times;</button>
        </h2>
        <nav>
            <ul>
                <li class="py-3 px-2 hover:bg-[#757575] rounded-lg transition-colors">
                    <a href="{{ route('etudiant.dashboard') }}">Dashboard</a>
                </li>
                <li class="py-3 px-2 hover:bg-[#757575] rounded-lg transition-colors">
                    <a href="{{ route('etudiant.emplois_du_temps') }}">Emplois du temps</a>
                </li>
                <li class="py-3 px-2 hover:bg-[#757575] rounded-lg transition-colors">
                    <a href="{{ route('etudiant.notes') }}">Notes & Moyenne</a>
                </li>
                <li class="py-3 px-2 mt-8 flex justify-center">
                    <form action="{{ route('etudiant.logout') }}" method="GET">
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- Overlay mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        class="fixed inset-0  bg-opacity-40 z-30 md:hidden transition-opacity duration-300"
        x-transition.opacity></div>
    <!-- Contenu principal -->
    <div class="flex-1 flex flex-col min-h-screen md:ml-0">
        <header class="flex sm:justify-between items-center p-4 bg-white shadow-md justify-center">
            <h1 class="text-2xl font-bold">Bienvenue {{ session('etudiant')->nom ?? '' }}</h1>
        </header>
        <main class="p-4 flex-1">
            @yield('content')
        </main>
    </div>
    <script src="https://unpkg.com/alpinejs" defer></script>
</body>
</html>
