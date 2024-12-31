<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;
    protected $fillable = [
    'tipo',
    'codigo',
    'gestion',
    'diametro',
    'material',
    'profundidad',
    'origen',
    'destino',
    'inspection_id',
    ];
}
