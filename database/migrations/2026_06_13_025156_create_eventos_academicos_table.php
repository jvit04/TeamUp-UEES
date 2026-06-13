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
        Schema::create('eventos_academicos', function (Blueprint $table) {
            $table->id('id_evento');

            $table->foreignId('id_publicacion')
                ->unique()
                ->constrained('publicaciones', 'id_publicacion')
                ->cascadeOnDelete();

            $table->string('nombre_evento');
            $table->string('descripcion_evento');

            $table->date('fecha_evento');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->string('lugar');
            $table->string('expositor');
            $table->string('organizador');

            $table->enum('modalidad', [
                'PRESENCIAL',
                'VIRTUAL',
                'HIBRIDA'
            ]);

            $table->enum('estado_evento', [
                'PROGRAMADO',
                'FINALIZADO',
                'CANCELADO'
            ])->default('PROGRAMADO');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_academicos');
    }
};