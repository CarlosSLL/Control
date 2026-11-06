<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materiales', function (Blueprint $table) {

            // Eliminar columnas antiguas
            $table->dropColumn([
                'tamaño',
                'grosor',
                'tipo',
                'material_composicion'
            ]);
        });


        Schema::table('materiales', function (Blueprint $table) {

            // Crear relaciones nuevas

            $table->foreignId('categoria_id')
                ->nullable()
                ->after('nombre')
                ->constrained('categorias')
                ->restrictOnDelete();

            $table->foreignId('composicion_id')
                ->nullable()
                ->after('categoria_id')
                ->constrained('composiciones')
                ->restrictOnDelete();

        });
    }


    public function down(): void
    {
        Schema::table('materiales', function (Blueprint $table) {

            $table->string('tipo')->nullable();
            $table->string('material_composicion')->nullable();
            $table->string('tamaño')->nullable();
            $table->string('grosor')->nullable();

            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['composicion_id']);

            $table->dropColumn([
                'categoria_id',
                'composicion_id'
            ]);
        });
    }
};
