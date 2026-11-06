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
        Schema::create('detalles_solicitud' , function(Blueprint $table){
            $table->id();
            $table->foreignId('id_solicitud')->constrained('solicitudes')->cascadeOnDelete();
            $table->morphs('articulo');
            $table->decimal('cantidad',10,2);
            $table->enum('estado', ['Pendiente','Parcial', 'Entregado'])->default('Pendiente');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('detalles_solicitud');
    }
};
