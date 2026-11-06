<?php

namespace App\Livewire\Usuarios;

use App\Livewire\Traits\ModalTrait;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Usuarios extends Component
{
    use WithFileUploads;
      use ModalTrait;
    public $usuarioId =  null;
    public $nombres;
    public $apellidos;
    public $rol_id = '';
    public $estado = '';
    public $foto_path;
    public $email;
    public $password;




  public function guardar()
{
    $reglas = [
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'rol_id'    => 'required|integer',
            'estado'    => 'required|boolean',
            'foto_path' => 'nullable|image|max:10240',
            'email'     => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->usuarioId),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
            ],
        ];


    if ($this->usuarioId) {
        // Al editar, la contraseña no es obligatoria
        $reglas['password'] = 'nullable|string|max:255';
    }

    // Validamos con las reglas corregidas
    $this->validate($reglas);

    if ($this->usuarioId) {
        $usuario = User::findOrFail($this->usuarioId);

        $datos = [
            'nombres'   => $this->nombres,
            'apellidos' => $this->apellidos,
            'rol_id'    => $this->rol_id,
            'estado'    => $this->estado,
            'email'     => $this->email,
        ];

        if ($this->foto_path && !is_string($this->foto_path)) {
            if ($usuario->foto_path) {
                Storage::disk('public')->delete($usuario->foto_path);
            }
            $datos['foto_path'] = $this->foto_path->store('usuarios', 'public');
        }

        if (!empty($this->password)) {
            $datos['password'] = Hash::make($this->password);
        }

//         try {
//     $usuario->update($datos);
// } catch (\Exception $e) {
//     dd($e->getMessage());
// }
        $usuario->update($datos);

        $this->dispatch(
            'alerta',
            icon: 'success',
            title: 'Usuario actualizado correctamente'
        );

    } else {
        $rutaFoto = null;

        if ($this->foto_path) {
            $rutaFoto = $this->foto_path->store('usuarios', 'public');
        }

        User::create([
            'nombres'   => $this->nombres,
            'apellidos' => $this->apellidos,
            'rol_id'    => $this->rol_id,
            'estado'    => $this->estado,
            'foto_path' => $rutaFoto,
            'email'     => $this->email,
            'password'  => Hash::make($this->password),
        ]);

        $this->dispatch(
            'alerta',
            icon: 'success',
            title: 'Usuario creado correctamente'
        );
    }

    $this->cerrarModal();
}

public function editar($id){
    $usuario = User::findOrFail($id);

    $this->usuarioId    = $usuario->id;
    $this->nombres      = $usuario->nombres;
    $this->apellidos    = $usuario->apellidos;
    $this->rol_id       = $usuario->rol_id;
    $this->estado       = $usuario->estado;
    $this->foto_path    = null;
    $this->email        = $usuario->email;
    $this->password     = '';

    $this->openModal = true;
}

    public function eliminar($id){
         $usuario = User::findOrFail($id);

    // Eliminar la foto si existe
    if ($usuario->foto_path && Storage::disk('public')->exists($usuario->foto_path)) {
        Storage::disk('public')->delete($usuario->foto_path);
    }

    $usuario->delete();

    $this->dispatch(
        'alerta',
        icon: 'success',
        title: 'Usuario eliminado correctamente'
    );
    }

        private function resetFormulario()
    {
        $this->reset([
            'usuarioId',
            'nombres',
            'apellidos',
            'rol_id',
            'estado',
            'foto_path',
            'email',
            'password',
        ]);

        $this->resetValidation();


    }


    public function render()
    {
        $usuarios = User::all();
        $roles = Rol::all();
        return view('livewire.usuarios.usuarios',[
            'usuarios' => $usuarios,
            'usuariosActivos' => $usuarios->where('estado', 1)->count(),
            'totalUsuarios' => $usuarios->count(),
            'enProyecto' => User::whereHas('obras', function ($query) {
            $query->where('estado', 'En progreso');
        })->count(),
            'roles' => $roles
        ]);
    }
}
