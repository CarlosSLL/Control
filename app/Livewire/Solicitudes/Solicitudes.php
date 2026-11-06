<?php

namespace App\Livewire\Solicitudes;

use App\Models\Solicitud;
use Livewire\Component;

class Solicitudes extends Component
{

    public function render()
    {
        return view('livewire.solicitudes.solicitudes',[
            'solicitudes' => Solicitud::where('estado', '!=', 'Borrador')->get(),
            // 'misSolicitudes' => Solicitud::where('id_usuario',auth()->id())->get()
        ]);
    }
}
