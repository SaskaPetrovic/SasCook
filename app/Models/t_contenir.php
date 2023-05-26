<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_contenir extends Model
{
    use HasFactory;
    public $table = 't_contenir';
    protected $fillable = [
        'idIngredient',
        'idListeDeCourse',
    ];
}
