<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camara extends Model
{
    use HasFactory;
    protected $fillable = [
    'geom',
    'lng',
    'lat',
    'elevacion',
    'ubicacion',
    'codigo',
    'altura',
    'tipo',
    'rasante',
    'material',
    'diametro',
    'altapa',
    'tiptapa',
    'estado',
    'crokis',
    'diagrama',
    'user_id',
    ];

    public function inspection(){
        return $this->hasOne(Inspection::class)->with('detalles')->orderBy('detalles.orden', 'asc');
    }
}
