
@extends('layoutdashboard')

@section('title', 'Disponibilités')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Mes Disponibilités</h1>
    @if (session('success'))
        <div class="bg-green-500 text-white p-2 mb-4">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{route('disponibilite.create')}}" class="bg-blue-500 text-white p-2 rounded">Ajouter des disponibilités</a>
    <table class="min-w-full bg-white mt-4">
        <thead>
            <tr>
                <th class="py-2">Jour</th>
                <th class="py-2">Période</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($disponibilites as $disponibilite)
                <tr>
                    <td class="border px-4 py-2">{{ $disponibilite->jour }}</td>
                    <td class="border px-4 py-2">{{ $disponibilite->periode }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
