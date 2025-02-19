<!-- filepath: /c:/10projetlaravel/school_manage/resources/views/filament/pages/emplois-du-temps.blade.php -->
<x-filament::page>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4 text-blue-600 dark:text-blue-400">Emplois du Temps</h1>

        <!-- Affichage du formulaire généré par Filament -->
        <div class="bg-neutral-700 shadow-md rounded-lg p-6 mb-6">
            {{ $this->form }}
        </div>

        @if(!empty($emploisDuTemps))
            <h2 class="text-2xl font-semibold mb-4">
                Emplois du Temps pour {{ $anneeSemestre['annee_academique'] ?? '' }} - {{ $anneeSemestre['semestre_nom'] ?? '' }}
            </h2>

            <a href="{{ route('generate.pdf') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Télécharger en PDF
            </a>
            <a href="{{ route('send.emplois_du_temps_notification') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Envoyer par mail</a>

            @foreach($emploisDuTemps as $classe_nom => $emplois)
                <h3 class="text-xl font-semibold mb-2">Classe : {{ $classe_nom }}</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Horaire</th>
                                @foreach($jours as $jour)
                                    <th class="px-4 py-2 border-b">{{ $jour }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];
                            @endphp
                            @foreach($horaires as $horaire)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $horaire }}</td>
                                    @foreach($jours as $jour)
                                        <td class="px-4 py-2 border-b">
                                            @if(isset($emplois[$jour][$horaire]))
                                                @foreach($emplois[$jour][$horaire] as $cour)
                                                    <div class="mb-2">
                                                        <strong>Matière :</strong> {{ $cour->matiere_nom }}<br>
                                                        <strong>Enseignant :</strong> {{ $cour->enseignant_nom }}<br>
                                                        <strong>Salle :</strong> {{ $cour->salle_nom }}<br>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <p class="text-gray-600">Aucun emploi du temps à afficher pour la période sélectionnée.</p>
        @endif
    </div>
</x-filament::page>
