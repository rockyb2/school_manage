@extends('layoutdashboard')

@section('title', 'Fiche de note')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-50 p-6">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl border border-amber-100">

        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Créer une nouvelle composition</h2>

        <form action="{{ route('composition.store') }}" method="POST" class="space-y-6">
            @csrf

            <x-input label="Titre de la composition" class="text-xl p-2 border-1 border-gray-300" name="titre" placeholder="Ex: Composition Trimestre 1" required />

            <x-input label="Date" name="date" class="border-1 text-xl p-2 border-gray-300" type="date" required />

            {{-- Sélection du type --}}
            <div>
                <label for="type" class="block mb-2 text-sm font-medium text-gray-700">Type</label>
                <select name="type" id="type" required class="w-full border border-gray-300 rounded-md p-2">
                    <option value="">-- Sélectionner --</option>
                    <option value="examen">Examen</option>
                    <option value="composition">Evaluation</option>
                </select>
            </div>

            {{-- Sélection de la classe --}}
            <div>
                <label for="classe_id" class="block mb-2 text-sm font-medium text-gray-700">Classe</label>
                <select name="classe_id" id="classe_id" required class="w-full border border-gray-300 rounded-md p-2">
                    <option value="">-- Sélectionner la classe --</option>
                    @foreach ($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->nom_classe }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sélection de la matière --}}
            <div>
                <label for="matiere_id" class="block mb-2 text-sm font-medium text-gray-700">Matière</label>
                <select name="matiere_id" id="matiere_id" required class="w-full border border-gray-300 rounded-md p-2">
                    <option value="">-- Sélectionner la matière --</option>
                    @forelse ($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom_matiere }}</option>
                    @empty
                        <option value="">Aucune matière disponible</option>
                    @endforelse
                </select>
            </div>

            <x-button class="w-full justify-center bg-amber-500 hover:bg-amber-600">
                Créer la composition
            </x-button>
        </form>
    </div>
</div>
@endsection
