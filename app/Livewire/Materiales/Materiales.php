<?php

namespace App\Livewire\Materiales;

use App\Livewire\Traits\ModalTrait;
use App\Models\Categoria;
use App\Models\Composicion;
use App\Models\Material;
use App\Models\User;
use App\Services\SolicitudService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Materiales extends Component
{
    use WithFileUploads;
    use ModalTrait;

    public $materialId = null;
    public $value = null;
    public $nombre;
    public $categoria_id = '';
    public $composicion_id = '';
    public $descripcion;
    public $foto;
    public $cantidad;
    public $unidad = '';

    // --- Nuevo: estado para el flujo de solicitud ---
    public $obraActivaId = null;
    public $cantidadesSolicitud = []; // [material_id => cantidad]

    protected $rules = [
        'nombre'            => 'required|string|max:255',
        'categoria_id'      => 'required|integer',
        'composicion_id'    => 'required|integer',
        'descripcion'       => 'required|string|max:255',
        'foto'              => 'nullable|image|max:10240',
        'cantidad'          => 'nullable|numeric|min:0|max:50.2',
        'unidad'            => 'nullable|in:Piezas,Tramos',
    ];

public function mount()
{
    $user = Auth::user();

    if ($user instanceof User) {
        $obra = $user->obraActiva();
        $this->obraActivaId = $obra?->id;
    }
}

    public function updatedCategoriaId($value)
    {
        if ($value === '__nuevo__') {
            $this->categoria_id = '';
            $this->dispatch('abrir-alerta', tipo: 'categoria');
        }
    }

    public function updatedComposicionId($value)
    {
        if ($value === '__nuevo__') {
            $this->composicion_id = '';
            $this->dispatch('abrir-alerta', tipo: 'composicion');
        }
    }

    public function guardarCatalogo($tipo, $nombre)
    {
        switch ($tipo) {
            case 'categoria':
                Categoria::create([
                    'nombre' => $nombre,
                    'grupo' => 'Material',
                ]);
                break;

            case 'composicion':
                Composicion::create([
                    'nombre' => $nombre,
                ]);
                break;
        }
    }

    public function guardar()
    {
        $this->validate();

        if ($this->materialId) {
            $material = Material::findOrFail($this->materialId);

            $datos = [
                'nombre'         => $this->nombre,
                'categoria_id'   => $this->categoria_id,
                'composicion_id' => $this->composicion_id,
                'descripcion'    => $this->descripcion,
                'cantidad'       => $this->cantidad,
                'unidad'         => $this->unidad,
            ];

            if ($this->foto && !is_string($this->foto)) {
                if ($material->foto) {
                    Storage::disk('public')->delete($material->foto);
                }
                $datos['foto'] = $this->foto->store('materiales', 'public');
            }

            $material->update($datos);

            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Material actualizado correctamente'
            );
        } else {
            $rutaFoto = null;
            if ($this->foto) {
                $rutaFoto = $this->foto->store('materiales', 'public');
            }
            $material = Material::create([
                'nombre'         => $this->nombre,
                'categoria_id'   => $this->categoria_id,
                'composicion_id' => $this->composicion_id,
                'descripcion'    => $this->descripcion,
                'foto'           => $rutaFoto,
                'cantidad'       => $this->cantidad,
                'unidad'         => $this->unidad,
            ]);

            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Material creado correctamente'
            );
        }

        $this->cerrarModal();
    }

    public function editar($id)
    {
        $material = Material::findOrFail($id);

        $this->materialId     = $material->id;
        $this->nombre         = $material->nombre;
        $this->categoria_id   = $material->categoria_id;
        $this->composicion_id = $material->composicion_id;
        $this->descripcion    = $material->descripcion;
        $this->foto           = null;
        $this->cantidad       = $material->cantidad;
        $this->unidad         = $material->unidad;

        $this->openModal = true;
    }

    public function eliminar($id)
    {
        $material = Material::findOrFail($id);
        if ($material->foto && Storage::disk('public')->exists($material->foto)) {
            Storage::disk('public')->delete($material->foto);
        }
        $material->delete();
        $this->dispatch(
            'alerta',
            icon: 'success',
            title: 'Material eliminado correctamente'
        );
    }

    // ================================================================
    // NUEVO: flujo de solicitud
    // ================================================================

    /**
     * Agrega el material a la solicitud borrador de la obra activa
     * del usuario autenticado. La cantidad viene del input inline
     * (wire:model) por cada fila de la tabla, guardado en
     * $cantidadesSolicitud[$materialId].
     */
    public function solicitarMaterial(int $materialId, SolicitudService $service)
    {
        if (!$this->obraActivaId) {
            $this->dispatch(
                'alerta',
                icon: 'error',
                title: 'No tienes una obra activa asignada.'
            );
            return;
        }

        $cantidad = (int) ($this->cantidadesSolicitud[$materialId] ?? 0);

        if ($cantidad < 1) {
            $this->dispatch(
                'alerta',
                icon: 'error',
                title: 'Ingresa una cantidad válida.'
            );
            return;
        }

        try {
            $material = Material::findOrFail($materialId);

            $service->agregarItem(
                item: $material,
                cantidad: $cantidad,
                userId: Auth::id(),
                obraId: $this->obraActivaId
            );

            unset($this->cantidadesSolicitud[$materialId]);

            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Material agregado a la solicitud'
            );
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->dispatch('alerta', icon: 'error', title: $e->getMessage());
        } catch (\Exception $e) {
            $this->dispatch('alerta', icon: 'error', title: $e->getMessage());
        }
    }

    private function resetFormulario()
    {
        $this->reset([
            'nombre',
            'categoria_id',
            'composicion_id',
            'descripcion',
            'foto',
            'cantidad',
            'unidad',
        ]);

        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.materiales.materiales', [
            'materiales'    => Material::all(),
            'categorias'    => Categoria::where('grupo', 'Material')->get(),
            'composiciones' => Composicion::all(),
        ]);
    }
}
