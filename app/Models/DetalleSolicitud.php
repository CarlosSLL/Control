<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitud extends Model
{
    protected $table = 'detalles_solicitud';

    protected $fillable = [
        'id_solicitud',
        'articulo_type',
        'articulo_id',
        'cantidad',
        'cantidad_entregada',
        'estado',
    ];

    public function solicitud(){
        return $this->belongsTo(Solicitud::class, 'id_solicitud');
    }
    public function articulo(){
        return $this->morphTo();
}
}
