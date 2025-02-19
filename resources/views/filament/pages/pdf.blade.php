<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emplois du Temps</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('{{ storage_path("fonts/Poppins-Regular.ttf") }}') format('truetype');
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid black;
            padding: 3px;
            text-align: left;
        }

        th {
            background-color: #f3f4f6; /* Gray-200 */
        }

        .text-center {
            text-align: center;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .font-semibold {
            font-weight: 600;
        }

        .border {
            border: 1px solid black;
        }

        .overflow-x-auto {
            overflow-x: auto;
        }
    </style>
</head>
<body>


    @foreach($emploisDuTemps as $classe_nom => $emplois)
    <h1>Emplois du Temps</h1>
    <h2>{{ $anneeSemestre['annee_academique'] ?? '' }} - {{ $anneeSemestre['semestre_nom'] ?? '' }}</h2>
        <h3 class="font-semibold mb-2">Classe : {{ htmlentities($classe_nom, ENT_QUOTES, 'UTF-8') }}</h3>
        <div class="overflow-x-auto">
            <table class="border">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>08:00-12:30</th>
                        <th>12:30-13:00</th>
                        <th>13:00-17:00</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jours as $jour)
                        <tr>
                            <td>{{ $jour }}</td>
                            @php
                                $horaires = ['08:00-12:30', '12:30-13:00', '13:00-17:00'];
                            @endphp
                            @foreach($horaires as $horaire)
                                @if($horaire === '12:30-13:00')
                                    <td class="text-center">Pause</td>
                                @else
                                    <td>
                                        @if(isset($emplois[$jour][$horaire]))
                                            @foreach($emplois[$jour][$horaire] as $cour)
                                                <div class="mb-2">
                                                    <strong>Matière :</strong> {{ htmlentities($cour->matiere_nom, ENT_QUOTES, 'UTF-8') }}<br>
                                                    <strong>Enseignant :</strong> {{ htmlentities($cour->enseignant_nom, ENT_QUOTES, 'UTF-8') }}<br>
                                                    <strong>Salle :</strong> {{ htmlentities($cour->salle_nom, ENT_QUOTES, 'UTF-8') }}<br>
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</body>
</html>
