<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use App\Models\Annee_academique;
use App\Models\Semestre;

use Filament\Pages\Actions\Action; // Pour les actions de page

class EmploisDuTemps extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public ?string $annee_academique_id = null;
    public ?string $semestre_id = null;
    public array $emploisDuTemps = [];
    public array $anneeSemestre = [];
    public array $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static string $view = 'filament.pages.emplois_du_temps';


    protected function getFormSchema(): array
    {
        return [
            Select::make('annee_academique_id')
                ->label('Année Académique')
                ->default(Annee_academique::latest()->first()->id)
                ->options(Annee_academique::pluck('annee', 'id')->toArray())
                ->required(),
            Select::make('semestre_id')
                ->label('Semestre')
                ->default(Semestre::latest()->first()->id)
                ->options(Semestre::pluck('nom_semestre', 'id')->toArray())
                ->required(),
        ];
    }

    public function getActions(): array
    {
        return [
            Action::make('generate')
            ->label('Générer l\'emploi du temps')
            ->action('generateSchedule'),
        ];
    }

    public function generateSchedule(): void
    {
        if (!$this->annee_academique_id || !$this->semestre_id) {
            return;
        }

        $results = DB::table('emplois_du_temps as edt')
            ->join('cours as c', 'edt.cours_id', '=', 'c.id')
            ->join('classes as cl', 'c.classe_id', '=', 'cl.id')
            ->join('matieres as m', 'c.matiere_id', '=', 'm.id')
            ->join('enseignants as e', 'c.enseignant_id', '=', 'e.id')
            ->join('salles as s', 'c.salles_id', '=', 's.id')
            ->join('annee_academique as a', 'edt.annee_academique_id', '=', 'a.id')
            ->join('semestre as sem', 'edt.semestre_id', '=', 'sem.id')
            ->where('edt.annee_academique_id', $this->annee_academique_id)
            ->where('edt.semestre_id', $this->semestre_id)
            ->select(
                'c.*',
                'cl.nom_classe as classe_nom',
                'm.nom_matiere as matiere_nom',
                'e.nom as enseignant_nom',
                'e.email as enseignant_email',
                's.nom_salle as salle_nom',
                'a.annee as annee_academique',
                'sem.nom_semestre as semestre_nom',
                'c.jour',
                'c.heure_debut',
                'c.heure_fin'
            )
            ->get();

        // Initialiser le tableau pour regrouper les cours
        $emplois_du_temps = [];

        foreach ($results as $cour) {
            $horaire = $cour->heure_debut . '-' . $cour->heure_fin;
            $emplois_du_temps[$cour->classe_nom][$cour->jour][$horaire][] = $cour;
        }



        $this->emploisDuTemps = $emplois_du_temps;

        // Récupérer l'année académique et le semestre sélectionnés
        if ($results->isNotEmpty()) {
            $first = $results->first();
            $this->anneeSemestre = [
                'annee_academique' => $first->annee_academique,
                'semestre_nom' => $first->semestre_nom,
            ];
        } else {
            $this->anneeSemestre = [];
        }

        // Récupérer tous les enseignants uniques
//     $enseignants = collect($results)
//     ->unique('enseignant_email')
//     ->mapWithKeys(function ($item) {
//         return [$item->enseignant_email => $item->enseignant_nom];
//     });

// // Envoyer les emails
// foreach ($enseignants as $email => $nom) {
//     // Filtrer les cours par enseignant
//     $coursEnseignant = collect($results)
//         ->where('enseignant_email', $email)
//         ->groupBy('classe_nom');

//     Mail::to($email)->send(new EmploisDuTempsMail($coursEnseignant, $nom));
// }
    }



    // public function exportPdf()
    // {
    //     $this->generateSchedule();

    //     if (empty($this->emploisDuTemps)) {
    //         return back()->with('error', 'Aucun emploi du temps à exporter');
    //     }



    //     $pdf = PDF::loadView('filament.pages.pdf', [
    //         'emploisDuTemps' => $this->emploisDuTemps,
    //         'anneeSemestre' => $this->anneeSemestre,
    //         'jours' => $this->jours,
    //     ]);

    //     return $pdf->download('emplois_du_temps.pdf');
    // }

    public function render(): View
    {
        return view(static::$view, [
            'emploisDuTemps' => $this->emploisDuTemps,
            'anneeSemestre' => $this->anneeSemestre,
            'jours' => $this->jours,
        ]);
    }
}
