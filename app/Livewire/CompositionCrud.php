<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Compositions;
use App\Models\Notes;
use Illuminate\Support\Facades\DB;

class CompositionCrud extends Component
{

    public $compositions;
    public $titre;
    public $date;
    public $type;
    public $classe_id;
    public $matiere_id;
    public $composition_id;
    public $classes;
    public $matieres;
    public $showModal = false;
    public $isEditMode = false;
    public $showNoteModal = false;
    public $etudiants = [];
    public $notes = [];
    public $compositionSelectionnee;
    public function render()
    {
        return view('livewire.composition-crud');
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetFields()
    {
        $this->composition_id = null;
        $this->titre = '';
        $this->date = '';
        $this->type = '';
        $this->classe_id = '';
        $this->matiere_id = '';
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
        ]);
        $enseignant = session('enseignant');
        if (!$enseignant) {
            $this->dispatch('swal', [
                'title' => 'Non connecté',
                'text' => 'Veuillez vous connecter pour créer une composition.',
                'icon' => 'error'
            ]);
            return;
        }

        Compositions::create([
            'titre' => $this->titre,
            'date_composition' => $this->date,
            'type' => $this->type,
            'enseignant_id' => $enseignant->id,
            'classe_id' => $this->classe_id,
            'matiere_id' => $this->matiere_id,
        ]);

        $this->dispatch('swal', [
            'title' => 'Succès',
            'text' => 'Composition créée avec succès !',
            'icon' => 'success'
        ]);
        $this->closeModal();
        $this->resetFields();
        $this->compositions = \App\Models\Compositions::with(['classe', 'matiere'])
            ->where('enseignant_id', $enseignant->id)
            ->get();
    }

    public function edit($id)
    {
        $composition = Compositions::findOrFail($id);
        $this->composition_id = $composition->id;
        $this->titre = $composition->titre;
        $this->date = $composition->date_composition;
        $this->type = $composition->type;
        $this->classe_id = $composition->classe_id;
        $this->matiere_id = $composition->matiere_id;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'titre' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:examen,composition',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
        ]);

        $composition = Compositions::findOrFail($this->composition_id);
        $composition->update([
            'titre' => $this->titre,
            'date_composition' => $this->date,
            'type' => $this->type,
            'classe_id' => $this->classe_id,
            'matiere_id' => $this->matiere_id,
        ]);

        $this->dispatch('swal', [
            'title' => 'Mis à jour',
            'text' => 'Composition mise à jour avec succès.',
            'icon' => 'info'
        ]);
        $this->closeModal();
        $this->resetFields();
        $enseignant = session('enseignant');
        $this->compositions = \App\Models\Compositions::with(['classe', 'matiere'])
            ->where('enseignant_id', $enseignant->id)
            ->get();
    }


    public function delete($id)
    {
        $composition = Compositions::findOrFail($id);
        $composition->delete();

        $this->dispatch('swal', [
            'title' => 'Supprimé',
            'text' => 'Composition supprimée avec succès.',
            'icon' => 'warning'
        ]);
        $enseignant = session('enseignant');
        $this->compositions = \App\Models\Compositions::with(['classe', 'matiere'])
            ->where('enseignant_id', $enseignant->id)
            ->get();
    }


    public function mount()
    {
        $enseignant = session('enseignant');
        if (!$enseignant) {
            $this->classes = [];
            $this->matieres = [];
            $this->compositions = [];
        } else {
            $this->classes = DB::table('classes')
                ->join('cours', 'classes.id', '=', 'cours.classe_id')
                ->where('cours.enseignant_id', $enseignant->id)
                ->select('classes.nom_classe', 'classes.id')
                ->distinct()
                ->get();

            $this->matieres = DB::table('matieres')
                ->join('cours', 'matieres.id', '=', 'cours.matiere_id')
                ->where('cours.enseignant_id', $enseignant->id)
                ->select('matieres.nom_matiere', 'matieres.id')
                ->distinct()
                ->get();

            // Filtrer les compositions par enseignant connecté
            $this->compositions = \App\Models\Compositions::with(['classe', 'matiere'])
                ->where('enseignant_id', $enseignant->id)
                ->get();
        }
    }


    public function addNote($composition_id)
    {
        $composition = Compositions::findOrFail($composition_id);
        $this->compositionSelectionnee = $composition;
        // Récupère les étudiants de la classe liée à la composition
        $this->etudiants = $composition->classe->etudiants ?? [];
        // Initialise les notes existantes ou vides
        $this->notes = [];
        foreach ($this->etudiants as $etudiant) {
            $note = \App\Models\Notes::where('etudiant_id', $etudiant->id)
                ->where('composition_id', $composition_id)
                ->first();
            $this->notes[$etudiant->id] = $note ? $note->note : '';
        }
        $this->showNoteModal = true;
    }

    public function saveNotes()
    {
        foreach ($this->notes as $etudiant_id => $note) {
            if ($note !== '' && $note !== null) {
                \App\Models\Notes::updateOrCreate(
                    [
                        'etudiant_id' => $etudiant_id,
                        'composition_id' => $this->compositionSelectionnee->id,
                    ],
                    [
                        'note' => $note,
                    ]
                );
            }
        }
        $this->showNoteModal = false;
        $this->dispatch('swal', [
            'title' => 'Succès',
            'text' => 'Notes enregistrées avec succès.',
            'icon' => 'success'
        ]);
    }
}
