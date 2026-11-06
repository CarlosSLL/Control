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
        Schema::create('solicitudes', function (Blueprint $table){
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_obra')->constrained('obras')->cascadeOnDelete();
            $table->enum('tipo', ['Herramienta', 'Material']);
            $table->enum('estado', ['Borrador', 'Pendiente', 'Completada', 'Parcial', 'Cancelada'])->default('Borrador');
            $table->string('archivo')->nullable();
            $table->timestamp('fecha_solicitud')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('solicitudes');
    }
};
