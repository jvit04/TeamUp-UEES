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
        Schema::create('postulaciones_grupo', function (Blueprint $table) {
            $table->id('id_postulacion_grupo');

            $table->foreignId('id_grupo')
                ->constrained('grupos_concurso', 'id_grupo')
                ->cascadeOnDelete();

            $table->foreignId('id_usuario')
                ->constrained('users', 'id_usuario')
                ->cascadeOnDelete();

            $table->string('mensaje_postulacion')->nullable();

            $table->enum('estado_postulacion', [
                'PENDIENTE',
                'ACEPTADA',
                'RECHAZADA',
                'CANCELADA'
            ])->default('PENDIENTE');

            $table->dateTime('fecha_postulacion');
            $table->dateTime('fecha_respuesta')->nullable();
            $table->string('observacion_respuesta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulaciones_grupo');
    }
};