<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewer extends Model
{
    use HasFactory;
    protected $fillable = [
        'lng',
        'lat',
        'geom',
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
        'escalon',
        'observacion',
        'user_id',

    ];
    public function pipelines(){
        return $this->hasMany(Pipeline::class);
    }
    public function sumideros(){
        return $this->hasMany(Sumidero::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
