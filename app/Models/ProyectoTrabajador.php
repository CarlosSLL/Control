<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoTrabajador extends Model
{
    protected $table = 'proyecto_trabajador';

    protected $fillable = [
        'proyecto_id',
        'trabajador_id',
        'rol_proyecto',
        'fecha_asignacion',
        'fecha_salida',
        'observaciones',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Obra::class, 'proyecto_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'trabajador_id');
    }
}
