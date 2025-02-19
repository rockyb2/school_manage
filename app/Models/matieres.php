<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matieres extends Model
{
    /** @use HasFactory<\Database\Factories\MatieresFactory> */
    use HasFactory;
    protected $fillable=[
        'nom_matiere'
    ];

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
