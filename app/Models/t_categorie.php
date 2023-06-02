<?php
/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 16.05.2023
* Description : modèle de la table t_categorie
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_categorie extends Model
{
    use HasFactory;
    public $table = 't_categorie';
    protected $primaryKey = 'idCategorie';
    public $incrementing =true;
    public $timestamps=false;
    protected $fillable = [
        'idCategorie',
        'catNom',
    ];
}
