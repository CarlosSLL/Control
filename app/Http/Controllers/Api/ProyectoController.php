<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Obra;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $proyectos = Obra::all();
       return response()->json([
        'status'  => 'success',
        'count' => $proyectos->count(),
        'data' => $proyectos
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|in:En progreso,Inicio,Finalizado,Pendiente,Cancelado,En pausa',
            'inicio' => 'required|date',
            'fin'    => 'required|date',
        ]);

        $proyecto = Obra::create([
            'nombre' => $request->nombre,
            'estado' => $request->estado,
            'inicio' => $request->inicio,
            'fin' => $request->fin,
        ]);

        return response()->json([
        'status'  => 'success',
        'message' => 'Obra guardada correctamente desde la API.',
        'data'    => $proyecto
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
