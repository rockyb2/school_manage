<div class="p-4 bg-white shadow rounded-lg">
    <h2 class="text-lg font-semibold">Cours par classe</h2>
    <div class="mt-4">
        @foreach ($this->getData()['classesData'] as $classeData)
            <div class="mt-2">
                <p>Classe : {{ $classeData['classe'] }}</p>
                <p>Total de cours : {{ $classeData['totalCours'] }}</p>
                <ul>
                    @foreach ($classeData['enseignantsMatieres'] as $enseignantMatiere)
                        <li>{{ $enseignantMatiere['enseignant'] }} - {{ $enseignantMatiere['matiere'] }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
