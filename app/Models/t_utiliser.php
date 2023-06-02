<?php
/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 16.05.2023
* Description : modèle de la table t_utiliser
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_utiliser extends Model
{
    use HasFactory;
    public $table = 't_utiliser';
    protected $fillable = [
        'fkIngredient',
        'fkRecette',
        'utiQuantite',
    ];
    public $timestamps=false;
}
