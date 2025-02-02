<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salles extends Model
{
    /** @use HasFactory<\Database\Factories\SallesFactory> */
    use HasFactory;
    protected $fillable = [
        'nom_salle',
        'capacite'
    ];

    public function cours()
    {
        return $this->hasMany(Cours::class,'salles_id');
    }
}
