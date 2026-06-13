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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id('id_publicacion');

            $table->foreignId('id_usuario')
                ->constrained('users', 'id_usuario')
                ->cascadeOnDelete();

            $table->string('titulo');
            $table->text('descripcion');
            $table->string('imagen')->nullable();

            $table->enum('tipo_publicacion', [
                'CONCURSO',
                'CLUB',
                'EVENTO_ACADEMICO'
            ]);

            $table->date('fecha_publicacion');

            $table->enum('estado_publicacion', [
                'PUBLICADA',
                'OCULTA',
                'FINALIZADA'
            ])->default('PUBLICADA');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};