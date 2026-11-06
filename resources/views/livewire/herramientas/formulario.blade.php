            <div class="modal">
                <div class="modal-contenido">

                    {{-- Titulo del formulario --}}
                    <div class="titulo-modal">
                        <h1>{{ $herramientaId ? 'Editar Herramienta' : 'Nueva Herramienta' }}</h1>

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

                            {{-- Nombre la herramienta --}}
                            <div class="campo-formulario">
                                <label for="">Nombre de la heramienta</label>
                                <input wire:model="nombre" type="text" placeholder="Nombre">
                                @error('nombre')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- categoría --}}
                            <div class="campo-formulario">
                                <label for="">Categoría</label>
                                <select wire:model.live="categoria_id">
                                    <option value="" disabled selected >Seleccione una categoría</option>

                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach

                                    <option value="__nuevo__">+ Agregar nueva categoría</option>
                                </select>
                                 @error('categoria_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Numero de serie --}}
                            <div class="campo-formulario">
                                <label for="">Numero de serie</label>
                                 <input wire:model="numero_serie" type="text">
                                 @error('numero_serie')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Foto --}}
                            <div class="campo-formulario">
                                <label for="">Imagen</label>
                                <input type="file" wire:model="foto">
                                 @error('foto')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="campo-formulario ancho-completo">
                                <label for="">Descripción</label>
                                <textarea wire:model="descripcion" maxlength="200" name="" id=""
                                    placeholder="Ingresa la descripción"></textarea>
                                @error('descripcion')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Cantidad --}}
                            <div class="campo-formulario">
                                <label for="">Cantidad</label>
                                <input min="0" wire:model="cantidad" type="text" placeholder="Nombre">
                                @error('cantidad')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="ancho-completo"></div>
                            {{-- <div class="contenedor-botones ancho-completo"> --}}
                                 {{-- Boton para cerrar modal --}}
                                <button type="button" wire:click="cerrarModal" class="boton-blanco-flex">Cancelar</button>

                                {{-- Boton para guardar --}}
                                <button type="submit"
                                    class="boton-azul-flex">{{ $herramientaId ? 'Actualizar' : 'Guardar' }}</button>
                            {{-- </div> --}}

                        </form>
                    </div>
                </div>
            </div>
