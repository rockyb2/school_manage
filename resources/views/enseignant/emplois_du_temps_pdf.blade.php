<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emplois du Temps</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Emplois du Temps M.{{ $enseignant->nom}}</h1>
    <h2>{{ $anneeSemestre['annee_academique'] ?? '' }} - {{ $anneeSemestre['semestre_nom'] ?? '' }}</h2>

        <table>
            <thead>
                <tr>
                    <th>Horaire</th>
                    @foreach($jours as $jour)
                        <th>{{ $jour }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];
                @endphp
                @foreach($horaires as $horaire)
                    <tr>
                        <td>{{ $horaire }}</td>
                        @foreach($jours as $jour)
                            @if($horaire === '12:30-13:00')
                                <td>Pause</td>
                            @else
                                <td>
                                    @if(isset($emploisDuTemps[$jour][$horaire]) && count($emploisDuTemps[$jour][$horaire]) > 0)
                                        @foreach($emploisDuTemps[$jour][$horaire] as $cour)
                                            <strong>Matière :</strong> {{ $cour->matiere_nom }}<br>
                                            <strong>Classe :</strong> {{ $cour->classe_nom }}<br>
                                            <strong>Salle :</strong> {{ $cour->salle_nom }}<br>

                                        @endforeach
                                    @else
                                        <span>Pas de cours</span>
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

</body>
</html>
