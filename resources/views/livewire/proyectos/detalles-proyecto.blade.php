<div>
    <div class="page-header">
        <a class="" wire:navigate href="{{ route('proyectos.index') }}">
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
                 <h1>{{ $proyecto->nombre }}</h1>
                <p class="p-desc">{{ $proyecto->descripcion }}</p>

            <div class="descripcion-proyecto">
                <div class="icon-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />
                    </svg>
                    <p>{{ $proyecto->ubicacion }}</p>
                </div>
                <div class="icon-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
                        <path d="M17.001 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M19.001 15.5v1.5" />
                        <path d="M19.001 21v1.5" />
                        <path d="M22.032 17.25l-1.299 .75" />
                        <path d="M17.27 20l-1.3 .75" />
                        <path d="M15.97 17.25l1.3 .75" />
                        <path d="M20.733 20l1.3 .75" />
                    </svg>
                    <p class="destacado">{{ $proyecto->usuario?->nombres ?? 'Sin asignar' }}</p>
                </div>
                <div class="icon-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2l0 -12" />
                        <path d="M16 3l0 4" />
                        <path d="M8 3l0 4" />
                        <path d="M4 11l16 0" />
                        <path d="M8 15h2v2h-2l0 -2" />
                    </svg>
                    <p>{{ \Carbon\Carbon::parse($proyecto->inicio)->format('d/m/Y') }}</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 12l14 0" /><path d="M15 16l4 -4" /><path d="M15 8l4 4" /></svg>
                    <p> {{ \Carbon\Carbon::parse($proyecto->fin)->format('d/m/Y') }}</p>
                </div>
            </div>
            </div>

            <div class="resumen-card-progres">
                <div>
                    <div class="progreso-circular"
            style="--progreso: {{ $this->calcularProgreso($proyecto->inicio, $proyecto->fin) }}%;">

            <div class="progreso-circular__centro">
                <span>
                    {{ $this->calcularProgreso($proyecto->inicio, $proyecto->fin) }}%
                </span>
            </div>

        </div>

        <span class="progreso-titulo">PROGRESO</span>
                </div>
            </div>
        </div>
    </section>

    @if (in_array(auth()->user()->rol?->tipo_rol, ['Administrador', 'Director de proyectos', 'Líder de proyecto']))
        <div class="contenido-principal items-right">
            <button wire:click="abrirModal" class="boton-azul-flex">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Agregar
            </button>
        </div>
    @endif
    <div class="contenido-principal items-center">
        <table class="tabla">

            <thead>
                <tr>
                    <th>Trabajador</th>
                    <th>Contacto</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    @if (in_array(auth()->user()->rol?->tipo_rol, ['Administrador', 'Director de proyectos', 'Líder de proyecto']))
                        <th>Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($usuariosAsignados as $usuarioAsignado)
                    <tr>
                        <td class="nombres">
                            <div>
                                @if ($usuarioAsignado->foto_path)
                                    <img src="{{ asset('storage/' . $usuarioAsignado->foto_path) }}"
                                        alt="Foto del usuario">
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

                            </div>
                            <div>
                                {{ $usuarioAsignado->nombres }} <br>{{ $usuarioAsignado->apellidos }}
                            </div>
                        </td>

                        <td>
                            <div class="contacto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                                <p>
                                    {{ $usuarioAsignado->email }}
                                </p>

                            </div>
                        </td>
                        <td>
                            <p class="p-{{ $usuarioAsignado->rol->tipo_rol }}-p">{{ $usuarioAsignado->rol->tipo_rol }}
                            </p>
                        </td>
                        <td>
                            @if ($usuarioAsignado->estado === true)
                                <p class="estado-activo">
                                    Activo
                                </p>
                            @else
                                <p class="estado-inactivo">Inactivo</p>
                            @endif
                        </td>

                        @if (in_array(auth()->user()->rol?->tipo_rol, ['Administrador', 'Director de proyectos', 'Líder de proyecto']))
                            <td>
                                <button x-on:click="confirmarEliminar({{ $usuarioAsignado->id }})"
                                    class="boton-eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </td>
                        @endif
                    @empty
                        <td class="tabla_bacia">Sin Trabajadores asignados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($openModal)
        @teleport('body')
            @include('proyectos.modalTrabajadores')
        @endteleport
    @endif

    @script
        <script>
            window.confirmarEliminar = function(id) {

                Swal.fire({
                    title: 'Eliminar usuario?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $wire.eliminar(id);
                    }

                });

            }

            $wire.on('alerta', (event) => {

                Swal.fire({
                    icon: event.icon,
                    title: event.title,
                    showConfirmButton: false,
                    timer: 1800
                });

            });
        </script>
    @endscript

</div>
