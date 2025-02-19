<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-blue-600">Bonjour M{{ $enseignant->nom }},</h2>
        <p class="text-gray-700 mt-2">Voici votre nouvel emploi du temps :</p>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full border border-gray-300 shadow-md rounded-lg">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="px-4 py-2 border">Horaire</th>
                        @foreach($jours as $jour)
                            <th class="px-4 py-2 border">{{ $jour }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white text-gray-800">
                    @php
                        $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];
                    @endphp
                    @foreach($horaires as $horaire)
                        <tr class="{{ $horaire === '12:30-13:00' ? 'bg-gray-200 font-bold text-red-600' : 'hover:bg-gray-100' }}">
                            <td class="px-4 py-3 border text-center">{{ $horaire }}</td>
                            @foreach($jours as $jour)
                                @if($horaire === '12:30-13:00')
                                    <td class="border text-center">Pause</td>
                                @else
                                    <td class="px-4 py-3 border text-center">
                                        @if(isset($emploisDuTemps[$jour][$horaire]) && count($emploisDuTemps[$jour][$horaire]) > 0)
                                            @foreach($emploisDuTemps[$jour][$horaire] as $cour)
                                                <div class="p-2 bg-blue-100 rounded-lg shadow">
                                                    <span class="font-semibold text-blue-700">{{ $cour->matiere_nom }}</span><br>
                                                    <span class="text-gray-700">📚 {{ $cour->classe_nom }}</span><br>
                                                    <span class="text-gray-500">🏫 Salle: {{ $cour->salle_nom }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400">Pas de cours</span>
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="mt-6 text-gray-600">
            Cordialement,<br>
            <span class="font-semibold text-blue-500">L'administration</span>
        </p>
    </div>
</body>
</html>
