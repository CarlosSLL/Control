<?php

namespace App\Policies;

use App\Models\Obra;
use App\Models\Solicitud;
use App\Models\User;

class SolicitudPolicy
{
    private const OBRA_EN_PROGRESO = 'En progreso';

    /**
     * Matriz de permisos: qué tipo de solicitud puede crear cada rol.
     * Para cambiar reglas de negocio, solo se edita este array.
     */
    private const PERMISOS = [
        'lider'      => ['Material', 'Herramienta'],
        'trabajador' => ['Herramienta'],
    ];

    /**
     * Determina si $user puede crear una solicitud de $tipo en $obra.
     */
    public function crear(User $user, Obra $obra, string $tipo): bool
    {
        if ($obra->estado !== self::OBRA_EN_PROGRESO) {
            return false;
        }

        $rol = $this->obtenerRol($obra, $user->id);

        if ($rol === null) {
            return false;
        }

        return in_array($tipo, self::PERMISOS[$rol] ?? [], true);
    }

    /**
     * Resuelve el rol del usuario dentro de esta obra específica.
     * 'lider' si es el encargado (obras.id_usuario), 'trabajador' si
     * está en proyecto_trabajador sin fecha_salida, null si no tiene
     * relación con la obra.
     */
    public function obtenerRol(Obra $obra, int $userId): ?string
    {
        if ((int) $obra->id_usuario === $userId) {
            return 'lider';
        }

        $esTrabajadorActivo = $obra->proyectoTrabajador()
            ->where('trabajador_id', $userId)
            ->whereNull('fecha_salida')
            ->exists();

        return $esTrabajadorActivo ? 'trabajador' : null;
    }

    /**
 * ¿Puede ver el listado completo de todas las solicitudes?
 * (vista de almacén/admin)
 */
public function viewAny(User $user): bool
{
    return $user->esAdministrativo();
}

/**
 * ¿Puede ver ESTA solicitud en particular?
 */
public function view(User $user, Solicitud $solicitud): bool
{
    return $user->esAdministrativo() || $solicitud->id_usuario === $user->id;
}

/**
 * ¿Puede eliminar esta solicitud? Solo el dueño, y solo en Borrador.
 */
public function eliminar(User $user, Solicitud $solicitud): bool
{
    return $solicitud->id_usuario === $user->id && $solicitud->puedeEliminarse();
}

/**
 * ¿Puede confirmar (enviar al almacén) esta solicitud?
 */
public function confirmar(User $user, Solicitud $solicitud): bool
{
    return $solicitud->id_usuario === $user->id && $solicitud->estado === 'Borrador';
}
}
