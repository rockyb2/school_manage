<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    /** @use HasFactory<\Database\Factories\DisponibiliteFactory> */
    use HasFactory;
    protected $table = 'disponibilite';
    protected $fillable = [
        'enseignant_id',
        'Jour',
        'periode'
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
