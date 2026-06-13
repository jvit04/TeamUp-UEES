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
        Schema::create('postulaciones_club', function (Blueprint $table) {
            $table->id('id_postulacion_club');

            $table->foreignId('id_club')
                ->constrained('clubes', 'id_club')
                ->cascadeOnDelete();

            $table->foreignId('id_usuario')
                ->constrained('users', 'id_usuario')
                ->cascadeOnDelete();

            $table->string('motivo_postulacion');
            $table->string('experiencia_previa')->nullable();
            $table->string('disponibilidad_horaria');

            $table->enum('estado_postulacion', [
                'PENDIENTE',
                'ACEPTADA',
                'RECHAZADA',
                'CANCELADA'
            ])->default('PENDIENTE');

            $table->dateTime('fecha_postulacion');
            $table->dateTime('fecha_respuesta')->nullable();
            $table->string('observacion_respuesta')->nullable();

            $table->unique(['id_club', 'id_usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulaciones_club');
    }
};