<?php
/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 24.05.2023
* Description : modèle de la table t_planifier
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_planifier extends Model
{
    use HasFactory;
    public $table = 't_planifier';
    protected $fillable = [
        'fkUser',
        'created_at',
        'updated_at',
        'fkListeDeCourse',

    ];
    public $timestamps = true;
}
