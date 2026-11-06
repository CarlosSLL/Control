<div>
        <div class="page-header">
        <div class="titulo">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-package">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                <path d="M12 12l8 -4.5" />
                <path d="M12 12l0 9" />
                <path d="M12 12l-8 -4.5" />
                <path d="M16 5.25l-8 4.5" />
            </svg>
            <h1>Solicitudes</h1>
        </div>

        </div>
        <section class="resumen">
        <div class="resumen-card resumen-azul-oscuro">
            <h1>
                {{ $solicitudes->where('estado', 'Pendiente')->count() }}
            </h1>
            <p>Pendientes</p>
        </div>
        <div class="resumen-card resumen-verde">
            <h1>
                {{ $solicitudes->where('estado', 'Entregado')->count() }}
            </h1>
            <p>
                Entregadas
            </p>
        </div>
        <div class="resumen-card resumen-gris-azulado" >
            <h1>
                {{ $solicitudes->count() }}
            </h1>
            <p>Total solicitudes</p>
        </div>
    </section>

        {{-- Contenido principal --}}
    <div class="contenido-principal items-center">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Solicitante</th>
                    <th>Proyecto</th>
                    <th>Articulos</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                    <th>Reporte</th>
                </tr>
            </thead>
            <tbody>
                @forelse($solicitudes as $solicitud)
                <tr>
                    <td>{{ $solicitud->usuario->nombres }}</td>
                    <td>{{ $solicitud->obra->nombre }}</td>
                    <td>{{ $solicitud->detalles->count() }}</td>
                    <td>{{ $solicitud->tipo }}</td>
                    <td>{{ $solicitud->estado }}</td>
                    <td>
                        <a wire:navigate href="{{ route('detalles-solicitud', $solicitud) }}">Ver detalles</a>
                    </td>
                    <td>
                        @if($solicitud->archivo === null)
                            Sin archivo
                        @else
                        Enlace
                        @endif
                    </td>
                </tr>
                @empty
                    <td>Sin Solicitudes</td>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

