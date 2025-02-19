<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title', 'school_manage')</title>
</head>
<body class="flex h-full">
    <!-- Barre latérale -->
    <aside class="w-1/5 bg-gray-800 text-white p-4 h-screen">
        <h2 class="text-2xl font-bold mb-4">Menu</h2>
        <nav>
            <ul>
                <li class="mb-2"><a href="{{route('dashboard')}}" class="hover:underline">Dashboard</a></li>
                <li class="mb-2"><a href="{{route('emplois_du_temps')}}" class="hover:underline">Emplois du temps</a></li>
                <li class="mb-2"><a href="{{route('disponibilite.index')}}" class="hover:underline">Disponibilité</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <div class="flex-1 flex flex-col">
        <!-- En-tête -->
        <header class="flex justify-between items-center p-4 bg-white shadow-md">
            <div class="flex items-center">
                <img src="{{ asset('public/im.jpg') }}" alt="Icone Enseignant" class="w-10 h-10 rounded-full mr-4">
                <h1 class="text-2xl font-bold">Enseignant : {{ $enseignant->nom }}</h1>
            </div>
            <div>
                <button class="relative">
                <i class="fa-regular fa-bell h-6 w-6"></i>
                    <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
                </button>
            </div>
        </header>

        <!-- Section principale -->
        <main class="p-4 flex-1 bg-gray-100">
        @yield('content')
        </main>
    </div>
</body>
</html>
