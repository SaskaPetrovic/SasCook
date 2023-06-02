<?php
/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 24.05.2023
* Description : modèle de la table t_listedecourse
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_listeDeCourse extends Model
{
    use HasFactory;
    public $table = 't_listeDeCourse';
    protected $primaryKey = 'idListeDeCourse';
    protected $fillable = [
        'idListeDeCourse',
        'lisDate',
    ];
    public $timestamps = false;

}
