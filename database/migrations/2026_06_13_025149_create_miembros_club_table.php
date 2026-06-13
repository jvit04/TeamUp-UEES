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
        Schema::create('miembros_club', function (Blueprint $table) {
            $table->id('id_miembro_club');

            $table->foreignId('id_club')
                ->constrained('clubes', 'id_club')
                ->cascadeOnDelete();

            $table->foreignId('id_usuario')
                ->constrained('users', 'id_usuario')
                ->cascadeOnDelete();

            $table->dateTime('fecha_ingreso');
            $table->string('rol_miembro');

            $table->enum('estado_miembro', [
                'ACTIVO',
                'RETIRADO'
            ])->default('ACTIVO');

            $table->unique(['id_club', 'id_usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros_club');
    }
};