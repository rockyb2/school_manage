@extends('layoutdashboard')
@section('title', 'Notes et moyennes')

@section('content')
<h1 class="underline text-2xl">Notes et moyennes par matière</h1>

@foreach ($classes as $classe)
    <h2 class="text-xl mt-4 mb-2">{{ $classe->nom_classe }}</h2>
    @foreach ($classe->matieres as $matiere)
        <h3 class="text-lg font-semibold mb-2">{{ $matiere->nom_matiere }}</h3>
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nom</th>
                    <th class="py-2 px-4 border-b">Prénoms</th>
                    <th class="py-2 px-4 border-b">Notes</th>
                    <th class="py-2 px-4 border-b">Moyenne</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($classe->etudiants as $etudiant)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $etudiant->nom }}</td>
                        <td class="py-2 px-4 border-b">{{ $etudiant->prenoms }}</td>
                        <td class="py-2 px-4 border-b">
                            @php
                                $notes = $etudiant->notes_par_matiere[$matiere->nom_matiere]['notes'] ?? collect();
                            @endphp
                            @if($notes->count())
                                {{ implode(', ', $notes->toArray()) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ $etudiant->notes_par_matiere[$matiere->nom_matiere]['moyenne'] ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endforeach
@endsection
