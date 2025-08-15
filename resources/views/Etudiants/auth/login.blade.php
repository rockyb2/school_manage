<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>authentification E</title>
</head>

<body class="min-h-screen flex justify-center items-center bg-gray-100">

    <div class="flex flex-col w-full max-w-md p-6 bg-white shadow-lg rounded-xl mx-2">
        @if ($errors->any())
        <div class="bg-red-500 text-white p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('etudiant.auth.login') }}" method="post">
            <h1 class="text-3xl font-bold mb-6 text-center">Connexion</h1>
            @csrf
            <div class="mb-4">
                <input type="text" name="matricule" id="matricule" class="outline-none border-b-2 w-full p-2" placeholder="Matricule" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Se connecter</button>
        </form>
    </div>
</body>

</html>