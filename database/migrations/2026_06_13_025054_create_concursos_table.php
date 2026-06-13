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
        Schema::create('concursos', function (Blueprint $table) {
            $table->id('id_concurso');

            $table->foreignId('id_publicacion')
                ->unique()
                ->constrained('publicaciones', 'id_publicacion')
                ->cascadeOnDelete();

            $table->string('nombre_concurso');
            $table->string('descripcion_concurso');
            $table->string('area_concurso');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_limite_inscripcion');

            $table->integer('minimo_integrantes');
            $table->integer('maximo_integrantes');
            $table->integer('cupo_maximo_grupos');

            $table->enum('modalidad', [
                'PRESENCIAL',
                'VIRTUAL',
                'HIBRIDA'
            ]);

            $table->string('lugar');
            $table->string('requisitos');

            $table->enum('estado_concurso', [
                'DISPONIBLE',
                'CERRADO',
                'FINALIZADO',
                'CANCELADO'
            ])->default('DISPONIBLE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concursos');
    }
};