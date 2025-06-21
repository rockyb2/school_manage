@extends('layoutdashboard')

@section('title','Disponibilité')

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gray-100">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Définir Disponibilité</h2>
        <form action="{{ route('disponibilite.store') }}" method="post">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jour</label>
                <div class="flex flex-col space-y-4">
                    @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="jour[]" value="{{ $jour }}" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 transition-all duration-300"></div>
                            <div class="w-5 h-5 bg-white rounded-full shadow-md absolute left-0.5 top-0.5 peer-checked:left-5 transition-all duration-300"></div>
                            <span class="ml-3 text-gray-700">{{ $jour }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                <div class="flex flex-col space-y-4">
                    @foreach(['08H00-12H30', '13H00-17H00'] as $periode)
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="periode[]" value="{{ $periode }}" class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 transition-all duration-300"></div>
                            <div class="w-5 h-5 bg-white rounded-full shadow-md absolute left-0.5 top-0.5 peer-checked:left-5 transition-all duration-300"></div>
                            <span class="ml-3 text-gray-700">{{ $periode }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-all duration-300">Créer</button>
        </form>
    </div>

</div>


@endsection
