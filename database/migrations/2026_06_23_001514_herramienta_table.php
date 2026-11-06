<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('herramienta', function( Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->string('tamaño');
            $table->string('numero_serie');
            $table->string('descripcion');
            $table->string('cantidad');
            $table->string('estado');
            $table->string('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('herramientas');
    }
};
