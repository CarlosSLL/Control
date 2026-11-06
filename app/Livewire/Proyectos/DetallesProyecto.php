<?php

namespace App\Livewire\Proyectos;

use App\Livewire\Traits\ModalTrait;
use App\Models\Obra;
use App\Models\ProyectoTrabajador;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DetallesProyecto extends Component
{
    use ModalTrait;

    public Obra $proyecto;

    #[Validate('required|integer|exists:users,id')]
    public ?int $trabajador_id = null;

    #[Validate('required|integer|exists:obras,id')]
    public ?int $proyecto_id = null;

    public function mount(Obra $proyecto): void
    {
        $this->proyecto = $proyecto;
        $this->proyecto_id = $proyecto->id;
    }

    public function guardar(?int $trabajadorId = null): void
    {
        if ($trabajadorId) {
            $this->trabajador_id = $trabajadorId;
        }

        $validated = $this->validate();

        ProyectoTrabajador::create($validated);

        $this->reset('trabajador_id');
        $this->dispatch('notificar', 'Trabajador asignado con éxito');
    }

    public function eliminar(int $id): void
    {
       $prueba = ProyectoTrabajador::where('trabajador_id', $id)
        ->where('proyecto_id', $this->proyecto->id)
        ->delete();
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
        return view('livewire.proyectos.detalles-proyecto', [
            'usuariosAsignados' => User::query()
                ->whereRelation('proyectoTrabajador', 'proyecto_id', $this->proyecto->id)
                ->get(),

            'usuarios' => User::query()
                ->whereRelation('rol', 'tipo_rol', 'Trabajador')
                ->where('estado', true)
                ->whereDoesntHave('proyectoTrabajador.proyecto', function ($query) {
                    $query->where('estado', 'En progreso');
                })
                ->get(),
        ]);
    }
}
