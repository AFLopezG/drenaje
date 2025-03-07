<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo',
        'funcion',
        'gestion',
        'diametro',
        'material',
        'profundidad',
        'origen',
        'destino',
        'sewer_id',
    ];
    public function sewer(){
        return $this->belongsTo(Sewer::class);
    }
}
