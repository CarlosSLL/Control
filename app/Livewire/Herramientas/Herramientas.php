<?php

namespace App\Livewire\Herramientas;

use App\Livewire\Traits\ModalTrait;
use App\Models\Categoria;
use App\Models\Composicion;
use App\Models\Herramienta;
use App\Models\User;
use App\Services\SolicitudService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Herramientas extends Component
{
    use WithFileUploads;
    use ModalTrait;
    public $herramientaId;
    public $value = null;
    public $nombre;
    public $categoria_id ='';
    public $numero_serie;
    public $descripcion;
    public $cantidad;
    public $foto;

    public $obraActivaId = null;
    public $cantidadesSolicitud = [];

    protected $rules = [
        'nombre'        => 'required|string|max:255',
        'categoria_id'  => 'required|integer',
        'numero_serie'  => 'nullable|string|max:255',
        'descripcion'   => 'required|string|max:255',
        'cantidad'      => 'required|integer|min:0|max:100',
        'foto'          => 'nullable|image|max:10240',
    ];

    public function mount(){
        $user = Auth::user();
        if($user instanceof User){
            $obra = $user->obraActiva();
            $this->obraActivaId = $obra?->id;
        }
    }

    // Agregar una categoria para herramientas
    public function updatedCategoriaId($value){
        if($value === '__nuevo__'){
            $this->categoria_id = '';

            $this->dispatch('abrir-alerta', tipo:'categoria');
        }
    }

    // guardar categoria
    public function guardarCatalogo($tipo, $nombre){
          switch ($tipo) {

        case 'categoria':
            Categoria::create([
                'nombre' => $nombre,
                'grupo' => 'Herramienta',
            ]);
            break;

        case 'composicion':
            Composicion::create([
                'nombre' => $nombre,
            ]);
            break;
    }
    }

    // guardar / actualizar herramienta
    public function guardar(){
        $this->validate();

        if($this->herramientaId){
            $herramienta = Herramienta::findOrFail($this->herramientaId);

            $datos = [
                'nombre'        => $this->nombre,
                'categoria_id'  => $this->categoria_id,
                'numero_serie'  => $this->numero_serie,
                'descripcion'   => $this->descripcion,
                'cantidad'      => $this->cantidad,
            ];

            if($this->foto && !is_string($this->foto)){
                if($herramienta->foto){
                    Storage::disk('public')->delete($herramienta->foto);
                }
                $datos['foto'] = $this->foto->store('herramientas', 'public');
            }

            $herramienta->update($datos);
            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Herramienta actualizada correctamente'
            );
        } else{
            $rutaFoto = null;
            if($this->foto){
                $rutaFoto = $this->foto->store('herramientas', 'public');
            }
            $herramienta = Herramienta::create([
                'nombre'        => $this->nombre,
                'categoria_id'  => $this->categoria_id,
                'numero_serie'  => $this->numero_serie,
                'descripcion'   => $this->descripcion,
                'cantidad'      => $this->cantidad,
                'foto'          => $rutaFoto,
            ]);
            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Herramienta creada correctamente'
            );
        }
        $this->cerrarModal();
    }

    public function editar($id){
        $herramienta = Herramienta::findOrFail($id);

        $this->herramientaId= $herramienta->id;
        $this->nombre       = $herramienta->nombre;
        $this->categoria_id = $herramienta->categoria_id;
        $this->numero_serie = $herramienta->numero_serie;
        $this->descripcion  = $herramienta->descripcion;
        $this->cantidad     = $herramienta->cantidad;
        $this->foto         = null;

        $this->abrirModal();
    }

    public function eliminar($id){
        $herramienta = Herramienta::findOrFail($id);
        if($herramienta->foto && Storage::disk('public')->exists($herramienta->foto)){
            Storage::disk('public')->delete($herramienta->foto);
        }

        $herramienta->delete();
        $this->dispatch(
            'alerta',
            icon: 'success',
            title: 'Herramienta eliminado correctamente'
        );
    }

    private function resetFormulario(){
        $this->reset([
            'nombre',
            'categoria_id',
            'numero_serie',
            'descripcion',
            'cantidad',
            'foto',
        ]);

        $this->resetValidation();
    }

    public function solicitarHerramienta(int $herramientaId, SolicitudService $service){
        if(!$this->obraActivaId){
            $this->dispatch(
                'alerta',
                icon: 'error',
                title: 'No tienes una obra activa asignada',
            );
            return;
        }

        $cantidad = (int) ($this->cantidadesSolicitud[$herramientaId] ?? 0);

        if($cantidad < 1){
            $this->dispatch(
                'alerta',
                icon: 'error',
                title: 'Ingresa una cantidad válida'
            );
            return;
        }
        try {
            $herramienta = Herramienta::findOrFail($herramientaId);

            $service->agregarItem(
                item: $herramienta,
                cantidad: $cantidad,
                userId: Auth::id(),
                obraId: $this->obraActivaId
            );

            unset($this->cantidadesSolicitud[$herramientaId]);

            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Herramienta agregada a la solicitud'
            );
            }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->dispatch('alerta', icon: 'error', title: $e->getMessage());
            } catch (\Exception $e) {
            $this->dispatch('alerta', icon: 'error', title: $e->getMessage());

        }
    }
    public function render()
    {
        // $categorias = Categoria::all();
        // dd($categorias);
        return view('livewire.herramientas.herramientas',[

            'herramientas' => Herramienta::all(),
            'categorias'    => Categoria::where('grupo' , 'Herramienta')->get(),
        ]);
    }
}
