<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coefficents extends Model
{
    protected $fillable = [
        'matiere_id',
        'classe_id',
        'coefficent'
    ];


}
