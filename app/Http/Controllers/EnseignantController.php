<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enseignant;
use Illuminate\Support\Facades\DB;
use App\Notifications\EmptNotification;
use Illuminate\Support\Facades\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class EnseignantController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('enseignant')) {
            return redirect()->route('dashboard');
        }
        return view('enseignant.auth.login');
    }


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'mot_de_passe' => 'required',
    ]);

    $enseignantEmail = Enseignant::where('email', $request->email)
                            ->first();

                            if($enseignantEmail){
                                $enseignant = Enseignant::where('mot_de_passe', $request->mot_de_passe)
                                ->first();
                            }else{
                                return back()->withInput()->withErrors([
                                    'email' => 'L\'email ou le mot de passe ne correspond pas',
                                ]);
                            }

    if ($enseignant) {
        $request->session()->put('enseignant', $enseignant);
        return redirect()->route('dashboard');
    }

    return back()->withInput()->withErrors([
        'email' => 'L\'email ou le mot de passe ne correspond pas',
    ]);
}

    public function dashboard()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        // Calcul du total de cours
        $totalCours = DB::table('cours')
            ->where('enseignant_id', $enseignant->id)
            ->count();

        return view('enseignant.dashboard', compact('enseignant', 'totalCours'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('enseignant');
        return redirect('/');
    }

    public function sendEmploisDuTempsNotification()
    {
        $enseignants = Enseignant::all();

        foreach ($enseignants as $enseignant) {
            // Envoyer la notification
            $enseignant->notify(new EmptNotification());
        }

        return back()->with('success', 'Notifications envoyées avec succès.');
    }

    public function downloadEmploiDuTemps()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        // Récupérer les données de l'emploi du temps de l'enseignant
        $emploisDuTemps = $this->getEmploisDuTemps($enseignant->id);
        $anneeSemestre = [
            'annee_academique' => '2023-2024', // Remplacez par les données réelles
            'semestre_nom' => 'Semestre 1', // Remplacez par les données réelles
        ];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        // Générer le PDF
        $pdf = PDF::loadView('enseignant.emplois_du_temps_pdf', [
            'emploisDuTemps' => $emploisDuTemps,
            'anneeSemestre' => $anneeSemestre,
            'jours' => $jours,
            'enseignant' => $enseignant,
        ]);

        return $pdf->download('emplois_du_temps_M' . $enseignant->nom . '.pdf');
    }

    protected function getEmploisDuTemps($enseignantId)
    {
        $results = DB::table('emplois_du_temps as edt')
            ->join('cours as c', 'edt.cours_id', '=', 'c.id')
            ->join('classes as cl', 'c.classe_id', '=', 'cl.id')
            ->join('matieres as m', 'c.matiere_id', '=', 'm.id')
            ->join('enseignants as e', 'c.enseignant_id', '=', 'e.id')
            ->join('salles as s', 'c.salles_id', '=', 's.id')
            ->join('annee_academique as a', 'edt.annee_academique_id', '=', 'a.id')
            ->join('semestre as sem', 'edt.semestre_id', '=', 'sem.id')
            ->where('e.id', $enseignantId)
            ->select(
                'c.*',
                'cl.nom_classe as classe_nom',
                'm.nom_matiere as matiere_nom',
                'e.nom as enseignant_nom',
                's.nom_salle as salle_nom',
                'a.annee as annee_academique',
                'sem.nom_semestre as semestre_nom',
                'c.jour',
                'c.heure_debut',
                'c.heure_fin'
            )
            ->get();

        // Grouper les résultats par jour et par créneau horaire
        $grouped = [];
        foreach ($results as $cour) {
            $horaire = $cour->heure_debut . '-' . $cour->heure_fin;
            $grouped[$cour->jour][$horaire][] = $cour;
        }

        return $grouped;
    }

    public function showEmploisDuTemps()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        // Utilisation de la méthode qui retourne la structure groupée
        $emploisDuTemps = $this->getEmploisDuTemps($enseignant->id);
        $anneeSemestre = [
            'annee_academique' => '2025', // ou vos données réelles
            'semestre_nom' => 'Semestre 2', // ou vos données réelles
        ];
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        return view('enseignant.emplois_du_temps', compact('enseignant', 'emploisDuTemps', 'anneeSemestre', 'jours'));
    }

    public function getTotalCour()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $totalCours = DB::table('cours')
            ->where('enseignant_id', $enseignant->id)
            ->count();

        return response()->json(['total_cours' => $totalCours]);

    }

    public function getListClasses()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $classes = DB::table('classes')
            ->join('cours', 'classes.id', '=', 'cours.classe_id')
            ->where('cours.enseignant_id', $enseignant->id)
            ->select('classes.*')
            ->distinct()
            ->get();

        return view('enseignant.classes_list', compact('classes'));
    }



}
