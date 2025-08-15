<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emplois du temps PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background: #e0e7ff; }
    </style>
</head>
<body>
    <h2>Emplois du temps de {{ $etudiant->nom }}</h2>
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
            @foreach($horaires as $horaire)
                <tr>
                    <td>{{ $horaire }}</td>
                    @foreach($jours as $jour)
                        <td>
                            @if(isset($emploisDuTemps[$jour][$horaire]))
                                @foreach($emploisDuTemps[$jour][$horaire] as $cour)
                                    <div>
                                        <strong>{{ $cour->matiere_nom }}</strong><br>
                                        Salle : {{ $cour->salle_nom }}
                                    </div>
                                @endforeach
                            @else
                                <span style="color: #888;">Pas de cours</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>