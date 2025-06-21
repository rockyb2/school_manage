<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiants extends Model
{
    /** @use HasFactory<\Database\Factories\EtudiantsFactory> */
    use HasFactory;
    protected $fillable = [
        'classe_id',
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
        'photo',
        'date_inscription'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    protected static function booted()
{
    static::creating(function ($etudiant) {
        $annee = now()->format('Y');
        $mois = now()->format('m');
        $nom = strtoupper(substr($etudiant->nom, 0, 2));

        // Compter les étudiants inscrits ce mois-ci avec ce nom
        $count = self::whereYear('created_at', $annee)
            ->whereMonth('created_at', $mois)
            ->whereRaw('UPPER(LEFT(nom,2)) = ?', [$nom])
            ->count() + 1;

        $numero = str_pad($count, 2, '0', STR_PAD_LEFT);

        $etudiant->matricule = "{$annee}{$mois}{$nom}{$numero}";
    });
}
}
