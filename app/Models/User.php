<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'rol_id',
        'estado',
        'foto_path',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol(){
        return $this->belongsTo(Rol::class, 'rol_id');
    }
    public function esAdministrativo(): bool
{
    return in_array($this->rol?->tipo_rol, ['Administrador', 'Gestor de almacén'], true);
}

    public function obras(){
         return $this->hasMany(Obra::class, 'id_usuario');
    }
    public function proyectoTrabajador(){
        return $this->hasMany(ProyectoTrabajador::class, 'trabajador_id');
    }

    public function obraActiva(): ?\App\Models\Obra
{
    $comoLider = \App\Models\Obra::where('id_usuario', $this->id)
        ->where('estado', 'En progreso')
        ->first();

    if ($comoLider) {
        return $comoLider;
    }

    return \App\Models\Obra::where('estado', 'En progreso')
        ->whereHas('proyectoTrabajador', function ($query) {
            $query->where('trabajador_id', $this->id)
                  ->whereNull('fecha_salida');
        })
        ->first();
}
}
