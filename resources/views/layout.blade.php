<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'school_manage')</title>
    @vite('resources/css/app.css')
</head>
<body>
<header class="flex justify-between items-center p-4 bg-white text-black shadow-md">
        <p class="font-bold text-3xl text-slate-500">School-Manage</p>

        <nav>

    <a href="{{route('enseignant.auth.login')}}" class="m-2">Enseignant</a>

        <a href="{{ route('filament.admin.pages.dashboard') }}" class="m-2">Admin</a>
        </nav>

</header>
<main>
@yield('content')
</main>
</body>
</html>
