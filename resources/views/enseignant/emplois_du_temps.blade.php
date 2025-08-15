@extends('layoutdashboard')

@section('title','Emplois du temps ')

@section('content')
<main class="flex">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-blue-600 dark:text-blue-400">
            Emplois du Temps M.{{ $enseignant->nom}}
        </h1>
        <a href="{{ route('enseignant.emploi_du_temps_pdf') }}" class="bg-red-600 px-4 py-2 mb-4 text-white rounded-lg shadow hover:bg-red-800 transition">Télécharger en PDF</a>

        <div class="overflow-x-auto mt-3">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <thead>
                    <tr class="bg-white">
                        <th class="px-4 py-2 border-b border-r text-center font-semibold">Horaire</th>
                        @foreach($jours as $jour)
                            <th class="px-4 py-2 border-b text-center font-semibold">{{ $jour }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];
                    @endphp

                    @foreach($horaires as $horaire)
                        <tr>
                            <td class="px-4 py-2 border-b font-semibold text-center bg-gray-50">{{ $horaire }}</td>
                            @foreach($jours as $jour)
                                @if($horaire === '12:30-13:00')
                                    <td class="px-4 py-2 border-b text-center bg-gray-200 font-bold text-gray-600">Pause</td>
                                @else
                                    <td class="px-4 py-2 border-b text-center">
                                        @if(isset($emploisDuTemps[$jour][$horaire]) && count($emploisDuTemps[$jour][$horaire]) > 0)
                                            @foreach($emploisDuTemps[$jour][$horaire] as $cour)
                                                <div class="mb-2 p-2 rounded-lg bg-gray-100 shadow">
                                                    <span class="block text-sm text-blue-700 font-semibold">Matière :</span>
                                                    <span class="block text-base font-bold text-gray-800">{{ htmlentities($cour->matiere_nom, ENT_QUOTES, 'UTF-8') }}</span>
                                                    <span class="block text-sm text-blue-700 font-semibold mt-1">Classe :</span>
                                                    <span class="block text-base font-bold text-gray-800">{{ htmlentities($cour->classe_nom, ENT_QUOTES, 'UTF-8') }}</span>
                                                    <span class="block text-sm text-blue-700 font-semibold mt-1">Salle :</span>
                                                    <span class="block text-base font-bold text-gray-800">{{ htmlentities($cour->salle_nom, ENT_QUOTES, 'UTF-8') }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 italic">Pas de cours</span>
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection