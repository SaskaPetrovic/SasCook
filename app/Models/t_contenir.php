<?php
/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 24.05.2023
* Description : modèle de la table t_contenir
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_contenir extends Model
{
    use HasFactory;
    public $table = 't_contenir';
    protected $fillable = [
        'fkIngredient',
        'fkListeDeCourse',
        'conQuantite'
    ];
    public $timestamps = false;
    
}
