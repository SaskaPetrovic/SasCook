<?php

/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 16.05.2023
* Description : model de la table t_recette
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_recette extends Model
{
    use HasFactory;
    public $table = 't_recette';
    protected $primaryKey = 'idRecette';
    public $incrementing =true;
    protected $fillable = [
        'recTitre',
        'recTemps',
        'recDateAjout',
        'recPreparation',
        'recImageLien',
        'idUser',
        'recNbDePersonne',
    ];
}
