<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    /** @use HasFactory<\Database\Factories\ClasseFactory> */
    use HasFactory;

    protected $fillable =[
        'filiere_id',
        'nom_classe',
        'nb_etudiants'
    ];

    public function filiere()
{
    return $this->belongsTo(Filiere::class);
}

}
