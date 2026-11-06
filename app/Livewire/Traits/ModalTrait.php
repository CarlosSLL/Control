<?php

namespace App\Livewire\Traits;

trait ModalTrait
{
    public $openModal = false;
    public $modal = false;
 public function abrirModal()
    {
        // if (method_exists($this, 'resetFormulario')) {
        //     $this->resetFormulario();
        // }

        $this->openModal = true;
    }

    public function cerrarModal()
    {
        if (method_exists($this, 'resetFormulario')) {
            $this->resetFormulario();
        }

        $this->openModal = false;
    }

    public function abrirMenu(){
        $this->modal = true;
    }
}
