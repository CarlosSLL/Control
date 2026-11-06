<div>
    <div class="page-header">

        {{-- Titulo de pagina --}}
        <div class="titulo">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 21v-13l9 -4l9 4v13" />
                <path d="M13 13h4v8h-10v-6h6" />
                <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
            </svg>
            <h1>Gestión de Proyectos</h1>
        </div>

        {{-- Boton de crear un nuevo proyecto --}}
        @if(in_array(auth()->user()->rol?->tipo_rol, ['Administrador','Director de proyectos']))
        <button wire:click="abrirModal" class="boton-azul-flex" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Nuevo proyecto</button>
        @endif
    </div>

    @if(!in_array(auth()->user()->rol?->tipo_rol, ['Administrador','Director de proyectos']))
        @include('proyectos.components.user-view')
    @else
        @include('proyectos.components.admin-view')
    @endif

    {{-- Modal --}}
    @if ($openModal)
        @teleport('body')
            {{-- Formulario para crear un nuevo proyecto --}}
            @include('livewire.proyectos.formulario')
        @endteleport
    @endif

    @script
        <script>
            window.confirmarEliminar = function(id) {

                Swal.fire({
                    title: '¿Eliminar proyecto?',
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
