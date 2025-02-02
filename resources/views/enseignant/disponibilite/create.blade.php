@extends('layoutdashboard')

@section('title','Disponibilité')

@section('content')

<div class="flex justify-center items-center">

    <div class="rounded-lg">
        <form action="{{ route('disponibilite.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jour</label>
                <div class="flex flex-col">
                    <label><input type="checkbox" name="jour[]" value="Lundi"> Lundi</label>
                    <label><input type="checkbox" name="jour[]" value="Mardi"> Mardi</label>
                    <label><input type="checkbox" name="jour[]" value="Mercredi"> Mercredi</label>
                    <label><input type="checkbox" name="jour[]" value="Jeudi"> Jeudi</label>
                    <label><input type="checkbox" name="jour[]" value="Vendredi"> Vendredi</label>
                    <label><input type="checkbox" name="jour[]" value="Samedi"> Samedi</label>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Période</label>
                <div class="flex flex-col">
                    <label><input type="checkbox" name="periode[]" value="08H00-12H30"> 08H00-12H30</label>
                    <label><input type="checkbox" name="periode[]" value="13H00-17H00"> 13H00-17H00</label>
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Créer</button>
        </form>
    </div>

</div>

@endsection
