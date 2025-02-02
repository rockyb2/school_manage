<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiants extends Model
{
    /** @use HasFactory<\Database\Factories\EtudiantsFactory> */
    use HasFactory;
    protected $fillable =[
        'matricule',
        'nom',
        'prenoms',
        'age',
        'sexe',
        'tel_etudiant',
        'email',
        'date_naissance',
        'lieu_naissance',
        'nationalité',
        'nom_pere',
        'nom_mere',
        'nom_tuteur',
        'tel_pere',
        'tel_mere',
        'tel_tuteur',
        'date_inscription'
    ];
}
