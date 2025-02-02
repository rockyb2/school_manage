<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cours extends Model
{
    /** @use HasFactory<\Database\Factories\CoursFactory> */
    use HasFactory;

    protected $fillable =
    ['nom',
    'enseignant_id',
    'classe_id',
    'matiere_id',
    'jour',
    'heure_debut',
    'heure_fin',
    'salles_id'
];

public function enseignants(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    public function matieres(): BelongsTo
    {
        return $this->belongsTo(Matieres::class, 'matiere_id');
    }

    public function salles(): BelongsTo
    {
        return $this->belongsTo(Salles::class, 'salles_id');
    }

    public function emploisDuTemps()
{
    return $this->hasMany(Emplois_du_temps::class);
}
    }
