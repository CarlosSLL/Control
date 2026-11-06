<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    use HasFactory;
    protected $table = 'obras';
    protected $fillable = [
        'nombre',
        'id_usuario',
        'descripcion',
        'ubicacion',
        'estado',
        'inicio',
        'fin'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function proyectoTrabajador(){
        return $this->hasMany(ProyectoTrabajador::class, 'proyecto_id');
    }
    public function solicitud(){
        return $this->hasMany(Solicitud::class, 'id_obra');
    }

    public $timestamps = false;
}
