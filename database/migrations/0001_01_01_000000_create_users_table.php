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
        // Clave Primaria
        $table->id('id_usuario');

        // Clave Foránea (asumiendo que la tabla roles usa 'id' por defecto)
        $table->foreignId('id_rol')->references('id')->on('roles');

        // Datos Personales
        $table->string('nombres');
        $table->string('apellidos');
        $table->string('correo_institucional')->unique();
        $table->string('password');
        $table->string('carrera');
        $table->string('telefono');

        // Estado del usuario con valor por defecto
        $table->enum('estado_usuario', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');

        // created_at y updated_at
        $table->timestamps();
    });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
