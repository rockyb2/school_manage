<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'jour' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'enseignant_id' => 'required|exists:enseignants,id',
            'salles_id' => 'required|exists:salles,id',
        ]);

        $enseignant = Enseignant::find($request->enseignant_id);
        if (!$enseignant->isAvailable($request->jour, $request->periode)) {
            return back()->withErrors(['enseignant_id' => 'L\'enseignant sélectionné n\'est pas disponible à ce moment.']);
        }

        Cours::create($request->all());

        return redirect()->route('cours.index')->with('success', 'Cours créé avec succès');
    }
}
