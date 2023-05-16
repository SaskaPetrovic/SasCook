<?php

/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 16.05.2023
* Description : model de la table t_ingredient
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_ingredient extends Model
{
    use HasFactory;
    public $table = 't_ingredient';
    protected $primaryKey = 'idIngredient';
    public $incrementing =true;
    public $timestamps=true;
    protected $fillable = [
        'ingNom',
    ];
}
