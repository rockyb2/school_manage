@extends('Etudiants.layout')
@section('title','Dashboard étudiant')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-4 shadow-md rounded-md">
        <h2 class="text-xl font-bold mb-2">Bienvenue {{ $etudiant->nom }}</h2>
        <p class="text-gray-600">Votre espace étudiant vous permet de consulter vos emplois du temps, notes et moyennes.</p>
    </div>
    <div class="bg-white p-4 shadow-md rounded-md">
        <h2 class="text-xl font-bold mb-2">Nombre de matières</h2>
        <p class="text-3xl">{{ $etudiant->matieres_count ?? '...' }}</p>
    </div>
    <div class="bg-white p-4 shadow-md rounded-md">
        <h2 class="text-xl font-bold mb-2">Moyenne générale</h2>
        <p class="text-3xl">{{ $etudiant->moyenne_generale }} /20</p>
    </div>
</div>
@endsection