<?php

namespace App\Livewire\Solicitudes;

use App\Models\Solicitud;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MisSolicitudes extends Component
{
    public $idUsuario;
    public function mount(){
        // $this->idUsuario = Auth::id();
  
        }
    public function render()
    {
        return view('livewire.solicitudes.mis-solicitudes',[
            'misSolicitudes' => Solicitud::where('id_usuario',auth()->id())->get()
        ]);
    }
}
