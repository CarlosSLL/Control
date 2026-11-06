<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('herramienta', function (Blueprint $table) {
            $table->dropColumn([
                'tamaño',
                'tipo',
                'estado',
                'cantidad',
            ]);
        });

        Schema::table('herramienta', function (Blueprint $table) {

            $table->foreignId('categoria_id')
                ->after('nombre')
                ->constrained('categorias')
                ->restrictOnDelete();

            $table->integer('cantidad')->nullable();
        });

        // PostgreSQL
        DB::statement("
            ALTER TABLE herramienta
            ALTER COLUMN foto DROP NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('herramienta', function (Blueprint $table) {

            $table->dropForeign(['categoria_id']);

            $table->dropColumn([
                'categoria_id',
                'cantidad',
            ]);

            $table->string('tamaño')->nullable();
            $table->string('tipo')->nullable();
            $table->string('estado')->nullable();
            $table->string('cantidad')->nullable();
        });

        DB::statement("
            ALTER TABLE herramienta
            ALTER COLUMN foto SET NOT NULL
        ");
    }
};
