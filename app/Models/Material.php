<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
        use HasFactory;
    protected $table = 'materiales';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'categoria_id',
        'composicion_id',
        'descripcion',
        'foto',
        'cantidad',
        'unidad',
    ];

    public function categoria (){
        return $this->belongsTo(Categoria::class);
    }

    public function composicion(){
        return $this->belongsTo(Composicion::class);
    }

    public function detallesSolicitud(){
        return $this->morphMany(DetalleSolicitud::class, 'articulo');
    }

}
