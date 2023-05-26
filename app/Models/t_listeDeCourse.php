<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_listeDeCourse extends Model
{
    use HasFactory;
    public $table = 't_generer';
    protected $primaryKey = 'idRecette';
    protected $fillable = [
        'idListeDeCourse',
        'lisDate',
    ];
}
