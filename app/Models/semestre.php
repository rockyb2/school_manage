<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    /** @use HasFactory<\Database\Factories\SemestreFactory> */
    use HasFactory;

    protected $table = 'semestre';
    protected $fillable =[
        'nom_semestre',
        'date_debut',
        'date_fin'
    ];

}
