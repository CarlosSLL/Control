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
        Schema::create('materiales', function(Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->string('material_composicion');
            $table->string('descripcion');
            $table->string('grosor');
            $table->string('tamaño');
            $table->string('foto')->nullable();
            $table->string('cantidad');
            $table->string('estado');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('materiales');
    }
};
