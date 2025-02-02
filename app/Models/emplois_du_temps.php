<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cours;
use App\Models\Annee_academique;
use App\Models\Semestre;

class Emplois_du_temps extends Model
{
    /** @use HasFactory<\Database\Factories\EmploisDuTempsFactory> */
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'semestre_id',
        'annee_academique_id',


    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function anneeAcademique()
{
    return $this->belongsTo(Annee_academique::class, 'annee_academique_id');
}

public function semestre()
{
    return $this->belongsTo(Semestre::class, 'semestre_id');
}
}
