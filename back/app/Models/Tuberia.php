<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuberia extends Model
{
    use HasFactory;
    protected $fillable = [
    'geom',
    'codigo',
    'gestion', 
    'diametro',
    'material',
    'profundidad',
    'longitud',
    'origen_id',
    'destino_id',
    ];
}
