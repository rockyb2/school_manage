<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store($etudiant_id,$composition_id, Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'composition_id' => 'required|exists:compositions,id',
            'note' => 'required|numeric|min:0|max:20',
        ]);

        // Logique pour ajouter la note
        // Exemple : Note::create([...]);

        return response()->json(['message' => 'Note ajoutée avec succès.']);
    }
}
