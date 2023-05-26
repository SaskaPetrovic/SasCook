<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_planifier extends Model
{
    use HasFactory;
    public $table = 't_planifier';
    protected $fillable = [
        'id	',
        'created_at',
        'updated_at',
    ];
}
