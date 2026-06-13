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
        Schema::create('miembros_grupo', function (Blueprint $table) {
            $table->id('id_miembro_grupo');

            $table->foreignId('id_grupo')
                ->constrained('grupos_concurso', 'id_grupo')
                ->cascadeOnDelete();

            $table->foreignId('id_usuario')
                ->constrained('users', 'id_usuario')
                ->cascadeOnDelete();

            $table->enum('rol_en_grupo', [
                'LIDER',
                'INTEGRANTE'
            ])->default('INTEGRANTE');

            $table->date('fecha_union');

            $table->enum('estado_miembro', [
                'ACTIVO',
                'RETIRADO',
                'EXPULSADO'
            ])->default('ACTIVO');

            $table->unique(['id_grupo', 'id_usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros_grupo');
    }
};