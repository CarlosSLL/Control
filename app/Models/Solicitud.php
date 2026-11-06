<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $fillable = [
        'id_usuario',
        'id_obra',
        'tipo',
        'estado',
        'archivo',
        'fecha_solicitud'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function obra(){
        return $this->belongsTo(Obra::class, 'id_obra');
    }

    public function detalles(){
        return $this->hasMany(DetalleSolicitud::class, 'id_solicitud');
    }
     /**
     * Scope: filtra la solicitud en Borrador de un usuario, obra y
     * tipo específicos. Usado por SolicitudService para reutilizar
     * el borrador existente en vez de crear uno nuevo.
     */
    public function scopeBorrador($query, int $userId, int $obraId, string $tipo)
    {
        return $query->where('id_usuario', $userId)
                     ->where('id_obra', $obraId)
                     ->where('tipo', $tipo)
                     ->where('estado', 'Borrador');
    }

    
    /**
     * Regla de negocio: solo se puede eliminar una solicitud
     * mientras sigue en estado Borrador.
     */
    public function puedeEliminarse(): bool
    {
        return $this->estado === 'Borrador';
    }
}

