<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_generer extends Model
{
    use HasFactory;
    public $table = 't_generer';
    protected $fillable = [
        'idListeDeCourse',
        'idRecette',
    ];
}
