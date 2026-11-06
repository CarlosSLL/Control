<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\Request;

class ObraController extends Controller
{
    public function index(){
        $obras = Obra::get();
        return view('proyectos.index', compact('obras'));
    }
}
