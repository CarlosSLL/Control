<div class="modal">
                <div class="modal-contenido">

                    {{-- Titulo del formulario --}}
                    <div class="titulo-modal">
                        <h1>{{ $proyectoId ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</h1>

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

                    {{-- formulario --}}
                    <div class="formulario">
                        <form wire:submit.prevent="guardar">

                            {{-- Campos del formulario --}}

                            {{-- Nombre de proyecto --}}
                            <div class="campo-formulario">
                                <label for="">Ingrese el Nombre del Proyecto</label>
                                <input wire:model="nombre" type="text" placeholder="nombre">
                                @error('nombre')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Lider o encargado de proyecto --}}
                            <div class="campo-formulario">
                                <label for="">Líder o Encatgado del proyecto</label>
                                <select wire:model="id_usuario" name="" id="">
                                    <option value="">-- Seleccione un encargado --</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}"> {{ $usuario->nombres }}</option>
                                    @endforeach
                                </select>
                                @error('id_usuario')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="campo-formulario ancho-completo">
                                <label for="">Descripción</label>
                                {{-- <input type="text" placeholder="Descripcion del proyecto"> --}}
                                <textarea wire:model="descripcion" maxlength="200" name="" id=""
                                    placeholder="Ingresa la descripción"></textarea>
                                @error('descripcion')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Ubicación --}}
                            <div class="campo-formulario">
                                <label for="">Ubicación</label>
                                <input wire:model="ubicacion" type="text" placeholder="Ciudad, Estado">
                                @error('ubicacion')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Estado del proyecto --}}
                            <div class="campo-formulario">
                                <label for="">Escoga el estado del proyecyo</label>
                                <select wire:model="estado" name="" id="">
                                    <option value="" disabled> --Seleccionar una opcion-- </option>
                                    <option value="En progreso">En Progreso</option>
                                    <option value="En pausa">En Pausa</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Finalizado">Finalizado</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                                @error('estado')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Fecha de inicio --}}
                            <div class="campo-formulario">
                                <label for="">Fecha de Inicio</label>
                                <input wire:model="inicio" type="date" placeholder="Seleccione una fecha de inicio">
                                @error('inicio')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Fecha de fin --}}
                            <div class="campo-formulario">
                                <label for="">Fecha de Fin</label>
                                <input wire:model="fin" type="date" placeholder="Seleccione una fecha de fin">
                                @error('fin')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Boton para cerrar modal --}}
                            <button type="button" wire:click="cerrarModal" class="boton-blanco-flex">Cancelar</button>

                            {{-- Boton para guardar --}}
                            <button type="submit"
                                class="boton-azul-flex">{{ $proyectoId ? 'Actualizar' : 'Guardar' }}</button>
                        </form>
                    </div>
                </div>
            </div>
