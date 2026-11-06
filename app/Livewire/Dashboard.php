<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Obra;
use App\Models\Solicitud;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        $totalMateriales = DB::table('materiales')->count();
        $totalHerramientas = DB::table('herramienta')->count();
        $solicitudesPendientes = Solicitud::where('estado', 'Pendiente')->count();
        $proyectosEnProgreso = Obra::where('estado', 'En progreso')->count();

        $solicitudesRecientes = Solicitud::with(['usuario', 'obra'])
            ->latest()
            ->take(5)
            ->get();

        // Consulta de obras sin ninguna instrucción de ordenamiento
        $proyectos = Obra::where('estado', 'En progreso')
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'totalMateriales' => $totalMateriales,
            'totalHerramientas' => $totalHerramientas,
            'solicitudesPendientes' => $solicitudesPendientes,
            'proyectosEnProgreso' => $proyectosEnProgreso,
            'solicitudesRecientes' => $solicitudesRecientes,
            'proyectos' => $proyectos,
        ]);
    }
}
