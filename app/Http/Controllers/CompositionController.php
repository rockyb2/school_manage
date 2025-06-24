<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compositions;
use Illuminate\Support\Facades\Auth;

class CompositionController extends Controller
{


    public function index()
    {

        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }
        $compositions = Compositions::where('enseignant_id', $enseignant->id)->get();
        return view('enseignant.composition.index', compact('compositions', 'enseignant'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:examen,composition',

            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
        ]);

        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }


        $composition = Compositions::create([
            'titre' => $request->titre,
            'date_composition' => $request->date,
            'type' => $request->type,
            'enseignant_id' => $enseignant->id,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
        ]);

        return redirect()->route('composition.index')
        ->with('success', 'Composition créée avec succès.');
    }

    public function update(Request $request, Compositions $composition)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:examen,composition',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
        ]);

        $composition->update([
            'titre' => $request->titre,
            'date_composition' => $request->date,
            'type' => $request->type,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
        ]);

        return redirect()->route('composition.index')->with('success', 'Composition mise à jour avec succès.');
    }


    public function destroy(Compositions $composition)
    {


        $composition->delete();
        return redirect()->route('composition.index')->with('success', 'Composition supprimée avec succès.');
    }
}
