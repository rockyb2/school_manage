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
        $composition = Compositions::where('enseignant_id', $enseignant->id)->get();
        return view('enseignant.composition.index', compact('composition', 'enseignant'));
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

        $enseignant = Auth::guard('enseignant')->user();

        $composition = Compositions::create([
            'titre' => $request->titre,
            'date' => $request->date,
            'type' => $request->type,
            'enseignant_id' => $request->enseignant_id,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
        ]);

        return redirect()->route('enseignant.composition.index')
        ->with('success', 'Composition créée avec succès.');
    }
}
