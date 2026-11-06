<?php

namespace App\Services;

use App\Models\Solicitud;
use App\Models\DetalleSolicitud;
use App\Models\Obra;
use App\Models\Material;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SolicitudService
{
    /**
     * Agrega un material o herramienta a la solicitud en borrador
     * del usuario para esa obra, creando la solicitud si no existe.
     * Si el mismo artículo ya está en el borrador (pendiente), suma
     * la cantidad en vez de duplicar la fila de detalle.
     */
    public function agregarItem(Model $item, int $cantidad, int $userId, int $obraId): DetalleSolicitud
    {
        $tipo = $item instanceof Material ? 'Material' : 'Herramienta';
        $obra = Obra::findOrFail($obraId);
        $user = User::findOrFail($userId);

        if (Gate::forUser($user)->denies('crear', [Solicitud::class, $obra, $tipo])) {
            throw new AuthorizationException(
                "No tienes permiso para solicitar {$tipo} en esta obra."
            );
        }

        return DB::transaction(function () use ($item, $cantidad, $userId, $obraId, $tipo) {

            // Bloqueo para evitar condiciones de carrera si el usuario
            // hace doble clic o hay dos peticiones simultáneas
            $solicitud = Solicitud::borrador($userId, $obraId, $tipo)
                ->lockForUpdate()
                ->first();

            if (!$solicitud) {
                $solicitud = Solicitud::create([
                    'id_usuario' => $userId,
                    'id_obra'    => $obraId,
                    'tipo'       => $tipo,
                    'estado'     => 'Borrador',
                ]);
            }

            $detalle = $solicitud->detalles()
                ->where('articulo_type', get_class($item))
                ->where('articulo_id', $item->id)
                ->where('estado', 'Pendiente')
                ->first();

            if ($detalle) {
                $detalle->increment('cantidad', $cantidad);
                return $detalle->fresh();
            }

            return $solicitud->detalles()->create([
                'articulo_type' => get_class($item),
                'articulo_id'   => $item->id,
                'cantidad'      => $cantidad,
                'estado'        => 'Pendiente',
            ]);
        });
    }

    /**
     * Elimina una solicitud completa (y en cascada sus detalles).
     * Solo permitido mientras esté en estado Borrador.
     */
    public function eliminarSolicitud(Solicitud $solicitud): void
    {
        if (!$solicitud->puedeEliminarse()) {
            throw new \Exception('Solo se pueden eliminar solicitudes en borrador.');
        }

        $solicitud->delete(); // cascade borra detalles automáticamente
    }

    /**
     * Confirma la solicitud: pasa de Borrador a Pendiente y ya
     * no puede eliminarse a partir de este punto.
     */
    public function confirmar(Solicitud $solicitud): void
    {
        if ($solicitud->estado !== 'Borrador') {
            throw new \Exception('Solo se puede confirmar una solicitud en borrador.');
        }

        $solicitud->update([
            'estado'          => 'Pendiente',
            'fecha_solicitud' => now(),
        ]);
    }

    /**
     * Obtiene el borrador actual del usuario para esa obra y tipo,
     * con sus detalles y el artículo (Material/Herramienta) cargado.
     * Útil para mostrar la vista "resumen de solicitud en curso".
     */
    public function obtenerBorrador(int $userId, int $obraId, string $tipo): ?Solicitud
    {
        return Solicitud::borrador($userId, $obraId, $tipo)
            ->with('detalles.articulo')
            ->first();
    }

    /**
     * Elimina una sola línea de detalle del borrador (no toda la
     * solicitud). Solo permitido si la solicitud padre sigue en
     * Borrador.
     */
    public function eliminarDetalle(DetalleSolicitud $detalle): void
    {
        if (!$detalle->solicitud->puedeEliminarse()) {
            throw new \Exception('Solo se pueden quitar artículos mientras la solicitud está en borrador.');
        }

        $detalle->delete();
    }

    public function entregarSolicitud(Solicitud $solicitud): void
{
    DB::transaction(function () use ($solicitud) {

        $solicitud->load('detalles.articulo');

        foreach ($solicitud->detalles as $detalle) {
            $pendiente = $detalle->cantidad - $detalle->cantidad_entregada;

            if ($pendiente <= 0) {
                continue; // esta línea ya está completamente entregada
            }

            $articulo = $detalle->articulo()->lockForUpdate()->first();
            $disponible = $articulo->cantidad ?? 0;

            $aEntregar = min($pendiente, $disponible);

            if ($aEntregar <= 0) {
                continue; // sin stock, el detalle se queda en Pendiente tal cual
            }

            $articulo->decrement('cantidad', $aEntregar);

            $nuevaCantidadEntregada = $detalle->cantidad_entregada + $aEntregar;

            $detalle->update([
                'cantidad_entregada' => $nuevaCantidadEntregada,
                'estado' => $nuevaCantidadEntregada >= $detalle->cantidad
                    ? 'Entregado'
                    : 'Parcial',
            ]);
        }

        // Recalcula el estado general de la solicitud según sus detalles
        $solicitud->refresh();

        $todosEntregados = $solicitud->detalles->every(fn ($d) => $d->estado === 'Entregado');
        $algunoAvanzo = $solicitud->detalles->contains(
            fn ($d) => in_array($d->estado, ['Entregado', 'Parcial'], true)
        );

        $solicitud->update([
            'estado' => $todosEntregados
                ? 'Completada'
                : ($algunoAvanzo ? 'Parcial' : $solicitud->estado),
        ]);
    });
}
 
}
