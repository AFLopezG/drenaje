<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sumidero extends Model
{
    use HasFactory;
    protected $fillable = [
        'material',
        'tapa',
        'estado',
        'apertura',
        'sedimento',
        'altsed',
        'condicion',
        'sewer_id',
    ];
    public function sewer(){
        return $this->belongsTo(Sewer::class);
    }

}
