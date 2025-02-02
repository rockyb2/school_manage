<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee_academique extends Model
{
    /** @use HasFactory<\Database\Factories\AnneeAcademiqueFactory> */
    use HasFactory;
    protected $table = 'annee_academique';
    protected $fillable =[
        'annee'
    ];
}
