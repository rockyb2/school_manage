<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enseignant extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\EnseignantFactory> */
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenoms',
        'specialite',
        'tel',
        'email',
        'mot_de_passe'
    ];

    protected $hidden = [
        'mot_de_passe', // Cacher le mot de passe
    ];

    public function getAuthPassword(){
        return $this->mot_de_passe;
    }

    public function disponibilites()
    {
        return $this->hasMany(Disponibilite::class);
    }

    public function isAvailable($jour, $periode)
    {
        return $this->disponibilites()->where('jour', $jour)->where('periode', $periode)->exists();
    }

    public function cours(): HasMany
    {
        return $this->hasMany(Cours::class);
    }
}
