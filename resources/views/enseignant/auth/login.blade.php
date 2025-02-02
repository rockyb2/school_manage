<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>authentification E</title>
</head>
<body class="h-screen flex justify-center items-center">
<div class="flex w-1/3 flex-col p-4 bg-white shadow-md">
        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('login')}}" method="post">
            @csrf
            <div class="mb-4">
                <input type="password" name="mot_de_passe" id="password" class="outline-none border-b-2 w-full p-2" placeholder="mot de passe" required>
            </div>
            <button type="submit" class="text-center">Se connecter</button>
        </form>
    </div>
</body>
</html>
