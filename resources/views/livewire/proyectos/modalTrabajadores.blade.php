<div class="modal">
    <div class="modal-contenido small">
         {{-- Titulo del formulario --}}
            <div class="titulo-modal">
                <h2>Agregar Trabajador al Proyecto</h2>

                {{-- Cerrar modal --}}
                <button wire:click="cerrarModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        ill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </button>
             </div>

             <div class="formulario">
                  @forelse ($usuarios as $usuario)
                  <div class="formulario-detalles-trabajador">
                    <div class="formulario-nombres">
                            @if ($usuario->foto_path)
                                <img src="{{ asset('storage/' . $usuario->foto_path) }}" alt="Foto del usuario">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-user">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                                    <path
                                        d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" />
                                </svg>
                            @endif
                        <p> {{ $usuario->nombres }} {{ $usuario->apellidos }}</p>

                    </div>

                    <button wire:click="guardar({{ $usuario->id }})"
                        wire:loading.attr="disabled"
                        class="boton-azul-flex">
                        Agregar
                    </button>
                  </div>

                @empty
                    <p>No hay Trabajadores disponibles para asignar al proyecto.</p>
                @endforelse

             </div>
    </div>
</div>
