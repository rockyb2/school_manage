<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    protected $fillable = [
        'etudiant_id',
        'composition_id',
        'note'
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiants::class);
    }

    public function composition()
    {
        return $this->belongsTo(compositions::class);
    }
}
