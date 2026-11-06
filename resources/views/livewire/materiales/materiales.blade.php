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
            <h1>Materiales</h1>
        </div>

        @if(in_array(auth()->user()->rol?->tipo_rol, ['Administrador','Gestor de almacén']))
        <button wire:click="abrirModal" class="boton-azul-flex" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Nuevo Material
        </button>
        @endif
    </div>

    {{-- <section class="resumen">
        <div class="resumen-card">
            <p>filtro de materiales</p>
        </div>
    </section> --}}



    <div class="contenedor">
        @foreach ($materiales as $material)
            <article class="card">
                <div class="imagen-card">
                      @if ($material->foto)
                        <img src="{{ asset('storage/' . $material->foto) }}" alt="">
                    @else
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="128"
                            height="128"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#607d8b"
                            stroke-width="1"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            >
                            <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4" />
                            <path d="M14.5 5.5l4 4" />
                            <path d="M12 8l-5 -5l-4 4l5 5" />
                            <path d="M7 8l-1.5 1.5" />
                            <path d="M16 12l5 5l-4 4l-5 -5" />
                            <path d="M16 17l-1.5 1.5" />
                            {{-- <img src="{{ asset('storage/' . $herramienta->foto) }}" alt=""> --}}
                        </svg>
                    @endif
                </div>



                <h2 class="titulo-material">{{ $material->nombre }}</h2>
                <p>Categorí
                    a: {{ $material->categoria->nombre }}</p>
                <p>Material de composición: {{ $material->composicion->nombre }}</p>
                <p>Descripción: {{ $material->descripcion }}</p>
                <p>Cantidad: {{ $material->cantidad }} {{ $material->unidad }}</p>
                <div class="solicitar">
                     @if(!in_array(auth()->user()->rol?->tipo_rol, ['Administrador','Director de proyectos']))
                    <form wire:submit.prevent="solicitarMaterial({{ $material->id }})">
                        <input
                            type="number"
                            min="1"
                            wire:model="cantidadesSolicitud.{{ $material->id }}"
                            value="0"
                        >
                        <button type="submit" class="boton-editar" @disabled(!$obraActivaId)>
                            agregar
                        </button>
                    </form>
                    @else
                    <div class="botones">
                        <button
                        wire:click="editar({{ $material->id }})"
                        class="boton-editar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" /><path d="M16 5l3 3" /></svg>
                        </button>
                        <button
                        x-on:click="confirmarEliminar({{ $material->id }})"
                        class="boton-eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                        </button>
                    </div>
                    @endif
                </div>
            </article>
        @endforeach
    </div>

        {{-- Modal --}}
    @if ($openModal)
        @teleport('body')
            {{-- Formulario para crear un nuevo proyecto --}}
            @include('materiales.formulario')
        @endteleport
    @endif

@script
<script>
     window.confirmarEliminar = function(id) {

                Swal.fire({
                    title: '¿Eliminar material?',
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
    Livewire.on('abrir-alerta', ({ tipo }) => {

        Swal.fire({
            title: `Nueva ${tipo}`,
            input: 'text',
            inputLabel: `Nombre de la ${tipo}`,
            inputPlaceholder: `Escriba el nombre de la ${tipo}`,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal-superior'
            },

            preConfirm: async (nombre) => {

                if (!nombre.trim()) {
                    return Swal.showValidationMessage(`Debe escribir un nombre para la ${tipo}`);
                }

                try {
                    await $wire.guardarCatalogo(tipo, nombre);
                } catch (e) {
                    Swal.showValidationMessage('No se pudo guardar');
                }

            }

        });

    });

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
