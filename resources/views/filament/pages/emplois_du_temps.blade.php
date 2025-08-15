<!-- filepath: c:\10projetlaravel\school_manage\resources\views\filament\pages\emplois_du_temps.blade.php -->

<x-filament::page>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-100 py-8 px-2">
        <div class="container mx-auto max-w-5xl px-0 sm:px-4">
            <div class="mb-6">
                <nav class="flex flex-wrap items-center text-sm text-gray-500" aria-label="Breadcrumb">
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="hover:text-blue-700 font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-7 7-7-7"></path>
                        </svg>
                        Panneau d'administration
                    </a>
                    <span class="mx-2">/</span>
                    <span class="text-blue-700 font-bold">Emplois du temps</span>
                </nav>
            </div>
            <!-- Formulaire -->
            <div class="bg-white shadow-2xl rounded-2xl p-4 sm:p-8 mb-8 border border-blue-100">
                <h1 class="text-2xl sm:text-3xl font-bold text-blue-700 mb-6 text-center">Créer ou Générer un Emploi du Temps</h1>
                <form wire:submit.prevent="generateSchedule">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        {{ $this->form }}
                    </div>
                    <div class="flex flex-col md:flex-row gap-4 mt-6 justify-center">
                        <x-filament::button
                            type="submit"
                            class="!text-white bg-blue-600 hover:bg-blue-800 px-6 py-3 rounded-lg text-base sm:text-lg shadow"
                            icon="heroicon-o-calendar"
                            icon-class="text-white">Générer
                        </x-filament::button>
                    </div>
                </form>
            </div>

            @if(!empty($emploisDuTemps))
            <div class="mb-6 flex flex-col md:flex-row gap-4 justify-center">
                <a href="{{ route('generate.pdf') }}" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 sm:px-6 rounded shadow transition text-center">Télécharger en PDF</a>
                <a href="{{ route('send.emplois_du_temps_notification') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 sm:px-6 rounded shadow transition text-center">Envoyer par mail</a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 border border-blue-100">
                <h2 class="text-xl sm:text-2xl font-semibold mb-6 text-purple-700 text-center">
                    Emplois du Temps pour {{ $anneeSemestre['annee_academique'] ?? '' }} - {{ $anneeSemestre['semestre_nom'] ?? '' }}
                </h2>
                @foreach($emploisDuTemps as $classe_nom => $emplois)
                <h3 class="text-lg sm:text-xl font-bold mb-3 mt-8 text-blue-700">Classe : {{ $classe_nom }}</h3>
                <div class="overflow-x-auto mb-8">
                    <table class="min-w-[600px] w-full bg-white border border-gray-200 rounded-lg shadow text-xs sm:text-base">
                        <thead>
                            <tr class="bg-blue-100 text-blue-900">
                                <th class="px-2 sm:px-4 py-2 border-b">Horaire</th>
                                @foreach($jours as $jour)
                                <th class="px-2 sm:px-4 py-2 border-b border-l">{{ $jour }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];
                            @endphp
                            @foreach($horaires as $horaire)
                            <tr>
                                <td class="px-2 sm:px-4 py-2 border-b font-semibold bg-blue-50">{{ $horaire }}</td>
                                @foreach($jours as $jour)
                                <td class="px-2 sm:px-4 py-2 border-b border-l align-top">
                                    @if(isset($emplois[$jour][$horaire]))
                                    @foreach($emplois[$jour][$horaire] as $cour)
                                    <div class="mb-2 p-2 rounded-lg bg-purple-50 border border-purple-100 shadow-sm">
                                        <span class="block text-xs sm:text-sm text-purple-700 font-semibold">Matière :</span>
                                        <span class="block text-base font-bold text-gray-800">{{ $cour->matiere_nom }}</span>
                                        <span class="block text-xs sm:text-sm text-purple-700 font-semibold mt-1">Enseignant :</span>
                                        <span class="block text-base font-bold text-gray-800">{{ $cour->enseignant_nom }}</span>
                                        <span class="block text-xs sm:text-sm text-purple-700 font-semibold mt-1">Salle :</span>
                                        <span class="block text-base font-bold text-gray-800">{{ $cour->salle_nom }}</span>
                                    </div>
                                    @endforeach
                                    @else
                                    <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-600 text-center mt-8">Aucun emploi du temps à afficher pour la période sélectionnée.</p>
            @endif
        </div>
    </div>
</x-filament::page>
