            <div class="modal">
                <div class="modal-contenido">

                    {{-- Titulo del formulario --}}
                    <div class="titulo-modal">
                        <h1>{{ $usuarioId ? 'Actualizar Usuario' : 'Nuevo Usuario' }}</h1>

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

                            {{-- Nombre del usuario --}}
                            <div class="campo-formulario">
                                <label for="">Ingrese los Nombres del Usuario</label>
                                <input wire:model="nombres" type="text" placeholder="Nombres">
                                @error('nombres')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Apellidos del usuario --}}
                            <div class="campo-formulario">
                                <label for="">Ingrese los Apellidos del Usuario</label>
                                <input wire:model="apellidos" type="text" placeholder="Apellidos">
                                @error('apellidos')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Rol de usuario --}}
                            <div class="campo-formulario">
                                <label for="">Rol</label>
                                <select wire:model="rol_id" name="" id="">
                                    <option value="">-- Seleccione un encargado --</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}"> {{ $rol->tipo_rol }}</option>
                                    @endforeach
                                </select>
                                @error('rol_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Estado del usuario --}}
                            <div class="campo-formulario">
                                <label for="">Estado</label>
                                <select wire:model="estado" name="" id="">
                                    <option value="" disabled>-- Seleccione un encargado --</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                @error('estado')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Foto-path --}}
                            <div class="campo-formulario ancho-completo">
                                <label for="">Foto</label>
                                {{-- <input type="text" placeholder="Descripcion del proyecto"> --}}
                                <input type="file" wire:model="foto_path">
                                @error('foto_path')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="campo-formulario">
                                <label for="">Correo</label>
                                <input wire:model="email" type="email" placeholder="">
                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="campo-formulario">
                                <label for="">Contraseña</label>
                                <input wire:model="password" type="password" placeholder="">
                                @error('password')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Boton para cerrar modal --}}
                            <button type="button" wire:click="cerrarModal" class="boton-blanco-flex">Cancelar</button>

                            {{-- Boton para guardar --}}
                            <button type="submit"
                                class="boton-azul-flex">{{ $usuarioId ? 'Actualizar' : 'Guardar' }}</button>
                        </form>
                    </div>
                </div>
            </div>
