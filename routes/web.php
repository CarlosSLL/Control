<?php

use App\Http\Controllers\Api\ProyectoController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Livewire\Dashboard;
use App\Livewire\Herramientas\Herramientas;
use App\Livewire\Materiales\Materiales;
use App\Livewire\Proyectos\DetallesProyecto;
use App\Livewire\Proyectos\Index;
use App\Livewire\Solicitudes\DetallesSolicitud;
use App\Livewire\Solicitudes\Index as SolicitudesIndex;
use App\Livewire\Solicitudes\Solicitudes;
use App\Livewire\Usuarios\Usuarios;
use App\Models\Obra;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('usuarios', UserController::class);
// Route::resource('proyectos', ObraController::class);
Route::get('proyectos', Index::class)
->name('proyectos.index')
->middleware('auth', 'rol:Líder de proyecto,Administrador,Trabajador,Director de proyectos');

Route::get('usuarios', Usuarios::class)
->name('usuarios.index')
->middleware('auth', 'rol:Administrador');

Route::get('detalle-proyecto/{proyecto}',DetallesProyecto::class )
->name('detalle-proyecto')
->middleware('auth', 'rol:Líder de proyecto,Administrador,Trabajador,Director de proyectos');

Route::get('herramientas', Herramientas::class)
->name('herramientas.index')
->middleware('auth', 'rol:Líder de proyecto,Administrador,Gestor de almacén,Trabajador');

Route::get('materiales', Materiales::class)
->name('materiales.index')
->middleware('auth', 'rol:Líder de proyecto,Administrador,Gestor de almacén');

Route::get('solicitudes', SolicitudesIndex::class)
->name('solicitudes.index')
->middleware('auth', 'rol:Líder de proyecto,Administrador,Gestor de almacén,Trabajador');

Route::get('detalles-solicitud/{solicitud}', DetallesSolicitud::class)
->name('detalles-solicitud')
->middleware('auth', 'rol:Líder de proyecto,Administrador,Gestor de almacén,Trabajador');

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// Route::view('proyectos', 'proyectos.index')->name('proyectos.index');


require __DIR__.'/auth.php';
