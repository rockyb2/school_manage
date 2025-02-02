<?php

namespace App\Http\Controllers;

use App\Models\Disponibilite;
use Illuminate\Http\Request;

class DisponibiliteController extends Controller
{
    public function create()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }
        return view('enseignant.disponibilite.create', compact('enseignant'));
    }

    public function index()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $disponibilites = Disponibilite::where('enseignant_id', $enseignant->id)->get();

        return view('enseignant.disponibilite.index', compact('enseignant', 'disponibilites'));
    }

    public function show($id)
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $disponibilite = Disponibilite::findOrFail($id);

        return view('enseignant.disponibilite.show', compact('enseignant', 'disponibilite'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jour' => 'required|array',
            'periode' => 'required|array',
        ]);

        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        foreach($request->jour as $jour){
            foreach($request->periode as $periode){
                Disponibilite::create([
                    'enseignant_id' => $enseignant->id,
                    'Jour' => $jour,
                    'periode' => $periode
                ]);
            }
        }
        return redirect()->route('disponibilite.index')->with('success', 'Disponibilité ajoutée avec succès');
    }
}
