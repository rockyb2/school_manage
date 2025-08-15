@extends('Etudiants.layout')
@section('title','Notes & Moyenne')

@section('content')
<h1 class="text-2xl font-bold mb-4">Notes & Moyenne</h1>
@foreach($matieres as $matiere)
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">{{ $matiere->nom_matiere }}</h2>
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Notes</th>
                    <th class="py-2 px-4 border-b">Moyenne</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100 text-center">
                    <td class="py-2 px-4 border-b">
                        {{ $matiere->notes->count() ? implode(' ; ', $matiere->notes->toArray()) : '-' }}
                    </td>
                    <td class="py-2 px-4 border-b">
                        {{ $matiere->moyenne }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endforeach
@endsection
