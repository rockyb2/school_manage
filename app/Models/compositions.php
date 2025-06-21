<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compositions extends Model
{
    protected $fillable = [
        'titre',
        'date_composition',
        'type', // 'Interrogation', 'Devoir', etc.
        'enseignant_id',
        'matiere_id',
        'classe_id'
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matieres::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
