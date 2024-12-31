<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;
    protected $fillable = [
    'fecha',
    'estadotapa',
    'apertura',    
    'drenaje',
    'estadoci',
    'aro',
    'paredes',
    'solera',
    'condicion',
    'sedimento',
    'alturasedi',
    'estadosol',
    'escalon',
    'estadofis',
    'observacion',
    'user_id',
    'camara_id',
    ];

    public function detalles(){
        return $this->hasMany(Detalle::class);
    }
}
