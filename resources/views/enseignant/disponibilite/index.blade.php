@extends('layoutdashboard')

@section('title', 'Disponibilités')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Mes Disponibilités</h1>
    @if (session('success'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">{{ session('success') }}</div>
    @endif
    <a href="{{route('disponibilite.create')}}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition mb-4 inline-block">Ajouter des disponibilités</a>

    @php
        $grouped = $disponibilites->groupBy('jour');
    @endphp

    <div class="bg-white rounded-lg shadow p-6">
        @forelse ($grouped as $jour => $dispos)
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $jour }}</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach ($dispos as $disponibilite)
                        <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium shadow">
                            {{ $disponibilite->periode }}
                            <a href="{{ route('disponibilite.show', $disponibilite->id) }}" class="ml-2 text-xs bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 transition">Modifier</a>
                            <form action="{{ route('disponibilite.destroy', $disponibilite->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette disponibilité ?')">Supprimer</button>
                            </form>
                        </span>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-gray-500">Aucune disponibilité enregistrée.</div>
        @endforelse
    </div>
</div>
@endsection
