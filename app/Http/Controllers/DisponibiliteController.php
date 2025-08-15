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

        $erreurs = [];
        foreach ($request->jour as $jour) {
            foreach ($request->periode as $periode) {
                $existe = Disponibilite::where('enseignant_id', $enseignant->id)
                    ->where('Jour', $jour)
                    ->where('periode', $periode)
                    ->exists();

                if ($existe) {
                    $erreurs[] = "La disponibilité pour le jour $jour et la période $periode existe déjà.";
                }
            }
        }

        if (!empty($erreurs)) {
            return redirect()->back()->withErrors($erreurs);
        }

        // Enregistrer les disponibilités



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

    public function destroy(Disponibilite $disponibilite)
    {
        $disponibilite->delete();
        return redirect()->route('disponibilite.index')->with('success', 'Disponibilité supprimée avec succès');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jour' => 'required',
            'periode' => 'required',
        ]);

        $enseignant = session('enseignant');
        if (!$enseignant) {
            return redirect()->route('login')->withErrors(['message' => 'Veuillez vous connecter.']);
        }

        $disponibilite = Disponibilite::findOrFail($id);
        $disponibilite->update([
            'Jour' => $request->jour,
            'periode' => $request->periode
        ]);

        return redirect()->route('disponibilite.index')->with('success', 'Disponibilité modifiée avec succès');
    }
}
