
<div>
    <div class="page-header">
        <a wire:navigate href="{{ route('solicitudes.index') }}">Regresar</a>
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

    <div class="contenido-principal items-center">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Solicitado</th>
                    <th>Entregado</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitud->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->articulo->nombre ?? 'Artículo eliminado' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ $detalle->cantidad_entregada }}</td>
                        <td>{{ $detalle->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
         @if($solicitud->estado !== 'Completada')
            <button type="button" wire:click="abrirModalEntrega" class="boton-azul-flex">
                Entregar
            </button>
        @endif
    {{-- Modal de entrega --}}
    @if($openModal)
        @include('solicitudes.modal-atender-solicitud')
    @endif
</div>
