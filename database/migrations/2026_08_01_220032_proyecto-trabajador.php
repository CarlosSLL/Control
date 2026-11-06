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
        Schema::create('proyecto_trabajador', function (Blueprint $table){
            $table->id();
            $table->foreignId('proyecto_id')->constrained('obras')->restrictOnDelete();
            $table->foreignId('trabajador_id')->constrained('users')->restrictOnDelete();
            $table->string('rol_proyecto')->nullable();
            $table->timestamp('fecha_asignacion')->nullable();
            $table->timestamp('fecha_salida')->nullable();
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_trabajador');
    }
};
