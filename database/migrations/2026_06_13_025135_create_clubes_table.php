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
        Schema::create('clubes', function (Blueprint $table) {
            $table->id('id_club');

            $table->foreignId('id_publicacion')
                ->unique()
                ->constrained('publicaciones', 'id_publicacion')
                ->cascadeOnDelete();

            $table->foreignId('id_responsable')
                ->constrained('users', 'id_usuario')
                ->cascadeOnDelete();

            $table->string('nombre_club');
            $table->string('descripcion_club');
            $table->integer('cupos_disponibles');
            $table->string('horario');
            $table->string('lugar');
            $table->string('contacto');
            $table->string('requisitos');

            $table->enum('estado_club', [
                'DISPONIBLE',
                'SIN_CUPOS',
                'INACTIVO'
            ])->default('DISPONIBLE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubes');
    }
};