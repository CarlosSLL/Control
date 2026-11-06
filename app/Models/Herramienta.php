<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    use HasFactory;
     protected $table = 'herramienta';

    protected $fillable = [
        'nombre',
        'categoria_id',
        'tamaño',
        'numero_serie',
        'descripcion',
        'cantidad',
        'estado',
        'foto',
    ];

        public function categoria (){
        return $this->belongsTo(Categoria::class);
      }
    public function detallesSolicitud(){
        return $this->morphMany(DetalleSolicitud::class, 'articulo');
    }

    public $timestamps = false;
}
