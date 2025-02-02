
@foreach ($emplois_du_temps as $emplois_du_temps)
    @foreach ($cours as $cour)

        <table class="table-auto border-collapse border border-gray-400">
            <caption>Emplois du temps {{$cour->nom_classe}}</caption>
        <thead class="bg-bleu-200">
            <tr>
                <th class="border border-gray-400 px-4 py-2">Jour</th>
                <th class="border border-violet-400 px-4 py-2">Heure Début</th>
                <th class="border border-gray-400 px-4 py-2">Heure Fin</th>
                <th class="border border-gray-400 px-4 py-2">Cours</th>
                <th class="border border-gray-400 px-4 py-2">Classe</th>
            </tr>
        </thead>
        <tbody>

                <tr>
                    <td class="border border-gray-400 px-4 py-2">{{ $c->jour }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $c->heure_debut }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $c->heure_fin }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $c->cours }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $c->classe }}</td>
                </tr>


        </tbody>
    </table>
    @endforeach

@endforeach

