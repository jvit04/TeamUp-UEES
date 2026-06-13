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
        Schema::create('inscripciones_concurso', function (Blueprint $table) {
            $table->id('id_inscripcion');

            $table->foreignId('id_concurso')
                ->constrained('concursos', 'id_concurso')
                ->cascadeOnDelete();

            $table->foreignId('id_grupo')
                ->unique()
                ->constrained('grupos_concurso', 'id_grupo')
                ->cascadeOnDelete();

            $table->dateTime('fecha_inscripcion');

            $table->enum('estado_inscripcion', [
                'PENDIENTE',
                'CONFIRMADA',
                'RECHAZADA',
                'CANCELADA'
            ])->default('PENDIENTE');

            $table->string('codigo_inscripcion');
            $table->string('observacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones_concurso');
    }
};