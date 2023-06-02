<?php

/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 16.05.2023
* Description : modèle de la table t_recette
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
        'idRecette',
        'recTitre',
        'recTemps',
        'recDateAjout',
        'recPreparation',
        'recImageLien',
        'fkUser',
        'recNbDePersonne',
    ];
    public function categories()
    {
        return $this->belongsToMany(t_appartenir::class, 't_appartenir', 'fkRecette', 'fkCategorie');
    }
    public function ingredients()
    {
        return $this->belongsToMany(t_utiliser::class, 't_utiliser', 'fkRecette', 'fkIngredient');
    }
}
