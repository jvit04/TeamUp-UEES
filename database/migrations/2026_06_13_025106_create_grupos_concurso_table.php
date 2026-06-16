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
        Schema::create('grupos_concurso', function (Blueprint $table) {
            $table->id('id_grupo');

            $table->foreignId('id_concurso')
                ->constrained('concursos', 'id_concurso')
                ->cascadeOnDelete();

            $table->foreignId('id_lider')
                ->constrained('users', 'id_usuario')
                ->cascadeOnDelete();

            $table->string('nombre_grupo');
            $table->string('descripcion_grupo');
            $table->integer('cupo_maximo');

            $table->enum('estado_grupo', [
                'ABIERTO',
                'COMPLETO',
                'CERRADO'
            ])->default('ABIERTO');

            $table->timestamps();

            $table->unique(['id_concurso', 'nombre_grupo']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos_concurso');
    }
};