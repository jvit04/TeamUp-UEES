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
        Schema::create('users', function (Blueprint $table) {
            // Clave primaria personalizada según el modelo relacional
            $table->id('id_usuario');

            // Clave foránea hacia roles.id_rol
            $table->foreignId('id_rol')
                ->constrained('roles', 'id_rol')
                ->restrictOnDelete();

            // Datos personales
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo_institucional')->unique();
            $table->string('password');
            $table->string('carrera');
            $table->string('telefono');

            // Estado del usuario
            $table->enum('estado_usuario', [
                'ACTIVO',
                'INACTIVO'
            ])->default('ACTIVO');

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();

            // Se deja como user_id porque Laravel lo usa internamente para sesiones.
            $table->unsignedBigInteger('user_id')->nullable()->index();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};