<div>
       <div class="page-header">
        <a class="" wire:navigate href="{{ route('solicitudes.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 14l-4 -4l4 -4" />
                <path d="M5 10h11a4 4 0 1 1 0 8h-1" />
            </svg>
            Regresar
        </a>
    </div>

    <section class="resumen">
        <div class="resumen-card resumen-azul-oscuro-gradient">

            <div>
                <h1>{{ $solicitud->usuario->nombres }} {{ $solicitud->usuario->rol?->tipo_rol }}</h1>
                <p>{{ $solicitud->obra->descripcion }}</p>

                <p class="estado-{{ Str::slug($solicitud->estado) }}">Estado: {{ $solicitud->estado }}</p>
            </div>

            <div class="contador">
                <h1> {{ $solicitud->detalles->count() }}</h1>
                <p class=""> {{ $solicitud->tipo }}</p>

            </div>


        </div>
    </section>

           {{-- Contenido principal --}}
    <div class="contenido-principal items-center">
        <table class="tabla">
            <thead>
                <tr>
                    <th>No. Solicitud</th>
                    <th>Articulo</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    {{-- <th>Acciones</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($solicitud->detalles as $detalles)
                <tr>
                    <td>{{ $detalles->id_solicitud }}</td>
                    <td>{{ $detalles->articulo->nombre ?? 'Articulo Eliminado' }}</td>
                    <td>{{ $detalles->cantidad }} {{ $detalles->articulo->unidad }}</td>
                    <td>
                        {{ $detalles->estado }}
                    </td>
                </tr>
                @empty
                    <td>Sin Solicitudes</td>
                @endforelse

            </tbody>
        </table>
    </div>

    <div class="contenido-principal items-center">
        @can('confirmar', $solicitud)
        <button
            onclick="confirmarSolicitud({{ $solicitud->id }})"
            {{-- wire:confirm="¿Enviar esta solicitud al almacén? Ya no podras editarla." --}}
            class="boton-editar">
            Solicitar
        </button>
        @endcan

        @can('eliminar', $solicitud)
        <button
            onclick="eliminarSolicitud({{ $solicitud->id }})"
            {{-- wire:confirm="¿Eliminar esta solicitud?" --}}
            class="boton-eliminar">
            Cancelar
        </button>
        @endcan
    </div>

    @script
        <script>
            window.confirmarSolicitud = function(id){
                Swal.fire({
                    title: '¿Enviar solicitud al almacén?',
                    text: 'Ya no podrás editarla',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí enviar',
                    cancelButtonText: 'Cancelar',
                }).then((result)=> {
                    if (result.isConfirmed) {
                        Livewire.dispatch('confirmarSolicitud')
                    }
                })
            }

            window.eliminarSolicitud = function(id){
                Swal.fire({
                    title: '¿Deseas eliminar la solicitud?',
                    text: 'Ya no podrás revertir este proceso',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí eliminar',
                    cancelButtonText: 'Cancelar',
                }).then((result)=> {
                    if (result.isConfirmed) {
                        Livewire.dispatch('eliminarSolicitud')
                    }
                })
            }


               Livewire.on('alerta', (event) => {
                console.log('Evento de alerta', event)
                Swal.fire({
                    icon: event.icon,
                    title: event.title,
                    timer: 2000,
                    showConfirmButton: false,
                });
               });
        </script>
    @endscript
</div>
