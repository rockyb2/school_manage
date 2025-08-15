<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Matieres;
use App\Models\Notes;
use Illuminate\Support\Facades\DB;
use App\Models\Enseignant;
use App\Models\Compositions;

class NoteController extends Controller
{

    public function index(){
        $enseignant = session('enseignant');
    if (!$enseignant) {
        return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
    }
    $classes = $this->getListClasses();
    if (!$classes) {
        return redirect()->route('dashboard')->withErrors(['message' => 'Aucune classe trouvée.']);
    }

    foreach ($classes as $classe) {
        $classe->etudiants = $this->getEtudiantsByClasse($classe->id);
        // Récupérer les matières de la classe où l'enseignant intervient
        $matieres = DB::table('matieres')
            ->join('cours', 'matieres.id', '=', 'cours.matiere_id')
            ->where('cours.classe_id', $classe->id)
            ->where('cours.enseignant_id', $enseignant->id)
            ->select('matieres.id', 'matieres.nom_matiere')
            ->distinct()
            ->get();
        $classe->matieres = $matieres;

        foreach ($classe->etudiants as $etudiant) {
            $etudiant->notes_par_matiere = [];
            foreach ($matieres as $matiere) {
                // Récupérer les compositions de la matière pour la classe
                $composition_ids = \App\Models\Compositions::where('classe_id', $classe->id)
                    ->where('matiere_id', $matiere->id)
                    ->pluck('id');
                // Récupérer les notes de l'étudiant pour ces compositions
                $notes = \App\Models\Notes::where('etudiant_id', $etudiant->id)
                    ->whereIn('composition_id', $composition_ids)
                    ->pluck('note');
                $etudiant->notes_par_matiere[$matiere->nom_matiere] = [
                    'notes' => $notes,
                    'moyenne' => $notes->count() > 0 ? round($notes->avg(), 2) : null
                ];
            }
        }
    }

    return view('enseignant.notes.index', compact('enseignant', 'classes'));
    }


    public function getEtudiantsByClasse($classe_id){
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }
        $etudiants = DB::table('etudiants')
            ->join('classes', 'etudiants.classe_id', '=', 'classes.id')
            ->where('classes.id', $classe_id)
            ->select('etudiants.*')
            ->get();

        return $etudiants;
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
            ->select('classes.nom_classe', 'classes.id')
            ->distinct()
            ->get();

        return $classes;
    }
   public function getNotebyclass(){

   }

   public function getNotebyStudent(){
     $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

   }

   public static function calculMoyenneClasse(){

   }

   public static function calculMoyenneStudent(){
   }

}
