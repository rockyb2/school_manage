<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'school_manage')</title>
    @vite('resources/css/app.css')
</head>

<body>
     <header class="flex justify-between items-center p-4 bg-white text-black shadow-md relative">
        <p class="font-bold text-3xl text-slate-500">School-Manage</p>

        <!-- Bouton hamburger -->
        <div id="menu-btn" class="block md:hidden cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </div>

        <!-- Menu -->
        <nav id="menu" class="absolute top-full left-0 w-full bg-white md:static md:w-auto md:bg-transparent hidden md:block">
            <ul class="flex flex-col md:flex-row md:space-x-6 p-4 md:p-0">
                <li class=""><a href="{{ route('enseignant.auth.login') }}" class="m-2 block">Enseignant</a></li>
                <li><a href="{{ route('filament.admin.pages.dashboard') }}" class="m-2 block">Admin</a></li>
                <li><a href="{{ route('etudiant.auth.login') }}" class="m-2 block">Etudiant</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>

    <script>
        const menu_btn = document.getElementById('menu-btn')
        const links = document.getElementById('menu')

        menu_btn.addEventListener('click', ()=> {
            links.classList.toggle('hidden')

        })
    </script>
</body>

</html>
