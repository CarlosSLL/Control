            <div class="modal">
                <div class="modal-contenido">

                    {{-- Titulo del formulario --}}
                    <div class="titulo-modal">
                        {{-- <h1>{{ $usuarioId ? 'Actualizar Usuario' : 'Nuevo Usuario' }}</h1> --}}

                        {{-- Cerrar modal --}}
                        <button wire:click="cerrarModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <table class="tabla">
    <thead>
        <tr>
            <th>Artículo</th>
            <th>Pendiente</th>
            <th>Disponible</th>
            <th>Se entregará</th>
            <th>Quedará como</th>
        </tr>
    </thead>
    <tbody>
        @foreach($solicitud->detalles as $detalle)
            @php
                $pendiente = $detalle->cantidad - $detalle->cantidad_entregada;
                $disponible = $detalle->articulo->cantidad ?? 0;
                $aEntregar = min($pendiente, $disponible);
                $estadoResultante = $aEntregar <= 0
                    ? 'Pendiente'
                    : ($aEntregar >= $pendiente ? 'Entregado' : 'Parcial');
            @endphp
            <tr>
                <td>{{ $detalle->articulo->nombre ?? 'Artículo eliminado' }}</td>
                <td>{{ $pendiente }}</td>
                <td class="{{ $disponible < $pendiente ? 'text-red' : '' }}">
                    {{ $disponible }}
                </td>
                <td>{{ $aEntregar }}</td>
                <td>{{ $estadoResultante }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

        <div class="flex gap-2 mt-4">
            <button type="button" wire:click="cerrarModal" class="boton-blanco-flex">
                Cancelar
            </button>

            <button type="button" wire:click="confirmarEntrega" class="boton-azul-flex">
                Confirmar entrega
            </button>
        </div>
    </div>
</div>
