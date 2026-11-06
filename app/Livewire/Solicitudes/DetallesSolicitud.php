<?php

namespace App\Livewire\Solicitudes;

use App\Livewire\Traits\ModalTrait;
use App\Models\DetalleSolicitud;
use App\Models\Solicitud;
use App\Services\SolicitudService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class DetallesSolicitud extends Component
{
    use ModalTrait;
    public Solicitud $solicitud;
    public $solicitudId;

    #[On('confirmarSolicitud')]
    public function confirmar(SolicitudService $service){
        $this->authorize('confirmar', $this->solicitud);
        try {
            $service->confirmar($this->solicitud);
            $this->solicitud->refresh();

            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Solicitud enviada al almacén'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'alerta',
                icon: 'error',
                title: $e->getMessage()
            );
        }
    }
    public function abrirModalEntrega()
{
    $this->solicitud->load('detalles.articulo');
    $this->openModal = true;
}


#[On('eliminarSolicitud')]
    public function eliminar(SolicitudService $service){
        $this->authorize('eliminar', $this->solicitud);

         try {
            $service->eliminarSolicitud($this->solicitud);

            $this->dispatch(
                'alerta',
                icon: 'success',
                title: 'Solicitud eliminada'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'alerta',
                icon: 'error',
                title: $e->getMessage()
            );
        }
    }

    public function mount(Solicitud $solicitud){
        $this->solicitud = $solicitud->load('obra', 'usuario', 'detalles.articulo');
    }
    
    public function confirmarEntrega(SolicitudService $service)
{
    $this->authorize('viewAny', Solicitud::class);

    try {
        $service->entregarSolicitud($this->solicitud);
        // ...
    } catch (\Exception $e) {
        dd($e->getMessage()); // TEMPORAL — muestra el error real en pantalla
    }
}

    public function render()
    {
        // dd($this->solicitud->detalles);
        return view('livewire.solicitudes.detalles-solicitud', [
        // 'articulos' => DetalleSolicitud::where('id_usuario', $this->solicitudId)->get()
        ]);
    }
}
