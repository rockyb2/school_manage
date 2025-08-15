@extends('Etudiants.layout')
@section('title','Emplois du temps')

@section('content')
<h1 class="text-2xl font-bold mb-4">Emplois du temps</h1>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <thead>
            <tr class="bg-blue-100">
                <th class="px-4 py-2 border-b border-r text-center font-semibold">Horaire</th>
                @foreach($jours as $jour)
                    <th class="px-4 py-2 border-b text-center font-semibold">{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($horaires as $horaire)
                <tr>
                    <td class="px-4 py-2 border-b font-semibold text-center bg-gray-50">{{ $horaire }}</td>
                    @foreach($jours as $jour)
                        <td class="px-4 py-2 border-b text-center">
                            <!-- Affiche les cours de l'étudiant ici -->
                            @if(isset($emploisDuTemps[$jour][$horaire]))
                                @foreach($emploisDuTemps[$jour][$horaire] as $cour)
                                    <div class="mb-2 p-2 rounded-lg bg-blue-50 shadow">
                                        <span class="block text-sm text-blue-700 font-semibold">Matière :</span>
                                        <span class="block text-base font-bold text-gray-800">{{ $cour->matiere_nom }}</span>
                                        <span class="block text-sm text-blue-700 font-semibold mt-1">Salle :</span>
                                        <span class="block text-base font-bold text-gray-800">{{ $cour->salle_nom }}</span>
                                    </div>
                                @endforeach
                            @else
                                <span class="text-gray-400 italic">Pas de cours</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="{{ route('etudiant.emplois_du_temps_pdf') }}" class="bg-red-600 px-4 py-2 m-4 text-white rounded-lg shadow hover:bg-red-800 transition">Télécharger en PDF</a>
@endsection