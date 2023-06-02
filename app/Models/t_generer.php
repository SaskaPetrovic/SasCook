<?php
/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 24.05.2023
* Description : modèle de la table t_generer
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_generer extends Model
{
    use HasFactory;
    public $table = 't_generer';
    protected $fillable = [
        'fkListeDeCourse',
        'fkRecette',
    ];
    public $timestamps = false;
}
