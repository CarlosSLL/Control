<?php

namespace App\Livewire\Proyectos;

use App\Livewire\Traits\ModalTrait;
use App\Models\Obra;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{

      use ModalTrait;
    public $proyectoId = null;
    public $nombre;
    public $id_usuario;
    public $descripcion;
    public $ubicacion;
    public $estado = '';
    public $inicio;
    public $fin;

    public $menuAbierto = null;


    protected $rules = [
        'nombre'        => 'required|string|max:255',
        'id_usuario'    => 'required|integer',
        'descripcion'   => 'required|string|max:255',
        'ubicacion'     => 'required|string|max:255',
        'estado'        => 'required|in:En progreso,Inicio,Finalizado,Pendiente,Cancelado,En pausa',
        'inicio'        => 'required|date',
        'fin'           => 'required|date|after_or_equal:inicio',
    ];
    /**
     * Crear o actualizar un proyecto.
     */
    public function guardar()
    {

        $this->validate();

        if ($this->proyectoId) {

            $proyecto = Obra::findOrFail($this->proyectoId);

            $proyecto->update([
                'nombre'        => $this->nombre,
                'id_usuario'    => $this->id_usuario,
                'descripcion'   => $this->descripcion,
                'ubicacion'     => $this->ubicacion,
                'estado'        => $this->estado,
                'inicio'        => $this->inicio,
                'fin'           => $this->fin,
            ]);

             $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Proyecto actualizado correctamente'
            );

        } else {

            $proyecto = Obra::create([
                'nombre'        => $this->nombre,
                'id_usuario'    => $this->id_usuario,
                'descripcion'   => $this->descripcion,
                'ubicacion'     => $this->ubicacion,
                'estado'        => $this->estado,
                'inicio'        => $this->inicio,
                'fin'           => $this->fin,
            ]);

              $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Proyecto creado correctamente'
            );
        }

        $this->cerrarModal();
    }


    /**
     * Abrir modal para editar.
     */
    public function editar($id)
    {
        $proyecto = Obra::findOrFail($id);

        $this->proyectoId = $proyecto->id;
        $this->nombre = $proyecto->nombre;
        $this->id_usuario = $proyecto->id_usuario;
        $this->descripcion = $proyecto->descripcion;
        $this->ubicacion = $proyecto->ubicacion;
        $this->estado = $proyecto->estado;
        $this->inicio = date('Y-m-d', strtotime($proyecto->inicio));
        $this->fin = date('Y-m-d', strtotime($proyecto->fin));

        $this->menuAbierto = null;
        $this->openModal = true;
    }

    public function eliminar($id)
{
    try {
        $proyecto = Obra::findOrFail($id);
        $proyecto->delete();

        $this->dispatch(
            'alerta',
            icon: 'success',
            title: 'Proyecto eliminado correctamente'
        );

    } catch (\Exception $e) {

        $this->dispatch(
            'alerta',
            icon: 'error',
            title: 'Error al eliminar el proyecto',
            text: 'No se pudo eliminar el proyecto. Inténtalo nuevamente.'
        );
    }
}
    /**
     * Limpiar formulario.
     */
    private function resetFormulario()
    {
        $this->reset([
            'proyectoId',
            'nombre',
            'id_usuario',
            'descripcion',
            'ubicacion',
            'estado',
            'inicio',
            'fin',
        ]);

        $this->resetValidation();

        $this->estado = '';
    }

    /**
     * Mostrar/Ocultar menú de opciones.
     */
    public function toggleMenu($id)
    {
        $this->menuAbierto = $this->menuAbierto === $id ? null : $id;
    }

    public function calcularProgreso($inicio, $fin)
{
    $inicio = Carbon::parse($inicio);
    $fin = Carbon::parse($fin);
    $hoy = Carbon::now();

    // Todavía no comienza
    if ($hoy->lt($inicio)) {
        return 0;
    }

    // Ya terminó
    if ($hoy->gte($fin)) {
        return 100;
    }

    // Duración total del proyecto
    $duracion = $inicio->diffInSeconds($fin);

    // Tiempo transcurrido
    $transcurrido = $inicio->diffInSeconds($hoy);

    return round(($transcurrido / $duracion) * 100);
}

    public function render()
    {
        $proyectos = Obra::get();
          $usuarios = User::all();
          $id_usuario = Auth::id();

        return view('livewire.proyectos.index', [
            'proyectos' => $proyectos,
            'usuarios' => $usuarios,
            'misProyectos' => Obra::where('id_usuario', $id_usuario)->get(),
            'totalProyectos' => $proyectos->count(),
            'proyectosEnProgreso' => Obra::where('estado', 'En progreso')->count(),
        ]);
    }
}
