<div>
    <div class="page-header">
        <div class="titulo">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-user-cog">
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
            <h1>Gestion de usuarios</h1>
        </div>

        <button wire:click="abrirModal" class="boton-azul-flex" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Nuevo usuario
        </button>
    </div>
    <section class="resumen">
        <div class="resumen-card resumen-azul-oscuro">
            <h1>{{ $totalUsuarios }}</h1>
            <p>Total de trabajadores</p>
        </div>
        <div class="resumen-card resumen-verde">
            <h1>{{ $usuariosActivos }}</h1>
            <p>
                Trabajadores Activos
            </p>
        </div>
        <div class="resumen-card resumen-gris-azulado" >
            <h1>{{ $enProyecto }}</h1>
            <p>En proyecto</p>
        </div>
    </section>

    {{-- Contenido principal --}}
    <div class="contenido-principal items-center">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Rol</th>
                    <th>Proyecto</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr wire:key="usuario-{{ $usuario->id }}">
                        <td class="nombres">
                            <div>
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

                            </div>
                            <div>
                                {{ $usuario->nombres }} <br>{{ $usuario->apellidos }}
                            </div>
                        </td>
                        <td>
                          <div class="contacto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>
                             <p>
                            {{ $usuario->email }}
                            </p>
                        </div>

                        </td>
                        <td>
                            <p class="p-{{ $usuario->rol->tipo_rol }}-p">{{ $usuario->rol->tipo_rol }}</p>

                        </td>
                        <td>
                            <p>
                                @forelse ($usuario->obras->where('estado', 'En progreso') as $obra)
                                {{ $obra->nombre }}<br>
                                @empty
                                    Sin proyectos
                                @endforelse
                            </p>

                        </td>
                        <td>
                                @if ($usuario->estado === true)
                                    <p class="estado-activo">
                                        Activo
                                    </p>
                                @else
                                    <p class="estado-inactivo">Inactivo</p>

                                @endif
                        </td>
                        <td class="acciones">
                            <button wire:click="editar({{ $usuario->id }})" class="boton-editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                    <path d="M13.5 6.5l4 4" />
                                </svg>
                            </button>
                            {{-- <button
                            x-on:click="confirmarEliminar({{ $usuario->id }})"
                            class="boton-blanco-flex">
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
                            </button> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Modal --}}
    @if ($openModal)

        @teleport('body')
            {{-- Formulario para crear un nuevo Usuario --}}
            @include('usuarios.formulario')
        @endteleport
    @endif

    @script
        <script>
            window.confirmarEliminar = function(id) {

                Swal.fire({
                    title: '¿Eliminar usuario?',
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
