{{-- Resumen de paina --}}
<section class="resumen">
    <div class="resumen-card resumen-azul-oscuro">
        <h1>{{ $totalProyectos }}</h1>
        <p>Total de Proyectos</p>
    </div>
    <div class="resumen-card resumen-gris-azulado">
        <h1>{{ $proyectosEnProgreso }}</h1>
        <p>En curso</p>
    </div>
    <div class="resumen-card resumen-verde">
        <h1>{{ $proyectos->where('estado', 'Finalizado')->count() }}</h1>
        <p>Finalizados</p>
    </div>
</section>

{{-- Contenido principal --}}

{{-- Proyectos --}}
<div class="contenedor grid-2">
    @foreach ($proyectos as $proyecto)
        <div class="card">
            <div class="titulo-modal">
                <h2 class="titulo-card">{{ $proyecto->nombre }}</h2>
                <button wire:click="toggleMenu({{ $proyecto->id }})" class="boton-blanco">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M11 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                        <path d="M11 19a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                        <path d="M11 5a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    </svg>
                </button>
                @if ($menuAbierto === $proyecto->id)
                    <div class="dropdown">

                        <button wire:click="editar({{ $proyecto->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                <path d="M13.5 6.5l4 4" />
                            </svg>
                            Editar

                        </button>

                        <button x-on:click="confirmarEliminar({{ $proyecto->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Eliminar

                        </button>

                <a wire:navigate href="{{ route('detalle-proyecto', $proyecto) }}">
                Ver detalles
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-window-maximize">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 17a1 1 0 0 1 1 -1h3a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1l0 -3" />
                    <path d="M4 12v-6a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-6" />
                    <path d="M12 8h4v4" />
                    <path d="M16 8l-5 5" />
                </svg>
            </a>

                    </div>
                @endif
            </div>
            <p class="descripcion-proyecto"> {{ $proyecto->descripcion }}</p>

            <div class="card-content grid-3">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" /><path d="M17.001 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                    <p class="destacado">{{ $proyecto->usuario?->nombres ?? 'Sin asignar' }}</p>
                    <p>Líder de proyecto</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                    <p class="destacado">{{ $proyecto->proyectoTrabajador->count() }}</p>
                    <p>Trabajadores</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-file-3d">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                <path d="M12 13.5l4 -1.5" />
                <path d="M8 11.846l4 1.654v4.5l4 -1.846v-4.308l-4 -1.846l-4 1.846" />
                <path d="M8 12v4.2l4 1.8" />
            </svg>
                    <p class="destacado">{{ $proyecto->solicitud->count() }}</p>
                    <p>Solicitudes</p>
                </div>
            </div>

            <div>
                {{-- <div class="fecha-card">
                    <p>Inicio</p>
                    <p>Fin</p>
                </div> --}}
                <div class="barra-progreso">
                    <input type="range" min="0" max="100" value="{{ $this->calcularProgreso($proyecto->inicio, $proyecto->fin) }}"  disabled>
                    {{ $this->calcularProgreso($proyecto->inicio, $proyecto->fin) }} %
                </div>
                <div class="fecha-card">
                    <p>{{ \Carbon\Carbon::parse($proyecto->inicio)->format('d/m/Y') }}</p>
                    <p>{{ \Carbon\Carbon::parse($proyecto->fin)->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="card-footer">
                <div class="proyecto-ubicacion">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />
                    </svg>
                    <p>{{ $proyecto->ubicacion}}</p>
                </div>
                <div class="proyecto-estado estado-{{ Str::slug($proyecto->estado) }}">
                    @if (in_array($proyecto->estado, ['Pendiente', 'En pausa']))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-progress-alert">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                            <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                            <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                            <path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                            <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                            <path d="M12 8v4" />
                            <path d="M12 16v.01" />
                        </svg>
                    @elseif ($proyecto->estado === 'En progreso')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-loader-3">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 0 0 9 9a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9" />
                            <path d="M17 12a5 5 0 1 0 -5 5" />
                        </svg>
                    @elseif ($proyecto->estado === 'Finalizado')
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-dashed-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" />
                            <path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" />
                            <path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" />
                            <path d="M8.56 20.31a9 9 0 0 0 3.44 .69" />
                            <path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" />
                            <path d="M20.31 15.44a9 9 0 0 0 .69 -3.44" />
                            <path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" />
                            <path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                    @elseif ($proyecto->estado === 'Cancelado')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cancel"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M18.364 5.636l-12.728 12.728" /></svg>
                    @endif
                    <p>{{ $proyecto->estado }}</p>
                </div>

            </div>
        </div>
    @endforeach
</div>
