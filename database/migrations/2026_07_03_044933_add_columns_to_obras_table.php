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
        Schema::table('obras', function (Blueprint $table) {
            $table->foreignId('id_usuario')->nullable()->constrained('users')->after('nombre');
            $table->string('descripcion')->nullable()->after('estado');
            $table->string('ubicacion')->nullable()->after('descripcion');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obras', function (Blueprint $table) {
            $table->dropColumn(['id_usuario', 'descripcion', 'ubicacion' ]);
        });
    }
};
