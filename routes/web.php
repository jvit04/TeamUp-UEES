<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConcursoController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\EventoAcademicoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas principales de TeamUp-UEES
|--------------------------------------------------------------------------
|
| Rutas protegidas por autenticación para inicio, eventos académicos,
| concursos, clubes y perfil de usuario.
|
*/

Route::middleware(['auth'])->group(function () {
    // Inicio / Dashboard
    Route::get('/', [InicioController::class, 'index'])->name('inicio');
    Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');

    // Eventos académicos
    Route::get('/eventos-academicos', [EventoAcademicoController::class, 'index'])
        ->name('eventos-academicos.index');

    Route::get('/eventos-academicos/{id}', [EventoAcademicoController::class, 'show'])
        ->name('eventos-academicos.show');

    // Rutas de Concursos
    Route::get('/concursos', [ConcursoController::class, 'index'])->name('concursos.index');
    Route::get('/concursos/{id}', [ConcursoController::class, 'show'])->name('concursos.show');
    Route::post('/grupos/{id}/postular', [ConcursoController::class, 'postularGrupo'])->name('grupos.postular');

    // Rutas para creación de grupos
    Route::get('/concursos/{id}/crear-grupo', [ConcursoController::class, 'crearGrupo'])->name('grupos.crear');
    Route::post('/concursos/{id}/guardar-grupo', [ConcursoController::class, 'guardarGrupo'])->name('grupos.guardar');

    // Rutas para gestionar grupos y solicitudes
    Route::get('/mis-grupos', [ConcursoController::class, 'misGrupos'])->name('mis_grupos.index');
    Route::post('/postulaciones/{id}/responder', [ConcursoController::class, 'responderPostulacion'])->name('postulaciones.responder');
    Route::delete('/grupos/{id}/eliminar', [ConcursoController::class, 'eliminarGrupo'])->name('grupos.eliminar');
    Route::delete('/grupos/{id}/abandonar', [ConcursoController::class, 'abandonarGrupo'])->name('grupos.abandonar');
    Route::delete('/grupos/{idGrupo}/expulsar/{idUsuario}', [ConcursoController::class, 'expulsarMiembro'])->name('grupos.expulsar');

    // Rutas de Clubes
    Route::get('/clubes', [ClubController::class, 'index'])->name('clubes.index');
    Route::get('/clubes/{id}', [ClubController::class, 'show'])->name('clubes.show');
    Route::post('/clubes/{id}/postular', [ClubController::class, 'postularClub'])->name('clubes.postular');

    // Rutas para gestionar mis clubes y solicitudes
    Route::get('/mis-clubes', [ClubController::class, 'misClubes'])->name('mis_clubes.index');
    Route::post('/postulaciones-club/{id}/responder', [ClubController::class, 'responderPostulacion'])->name('postulaciones_club.responder');

    // Rutas para salir o expulsar de un club
    Route::delete('/clubes/{id}/abandonar', [ClubController::class, 'abandonarClub'])->name('clubes.abandonar');
    Route::delete('/clubes/{idClub}/expulsar/{idUsuario}', [ClubController::class, 'expulsarMiembro'])->name('clubes.expulsar');
    // Rutas para cancelar postulaciones pendientes
    Route::delete('/grupos/{id}/cancelar-postulacion', [App\Http\Controllers\ConcursoController::class, 'cancelarPostulacion'])->name('grupos.cancelar_postulacion');
    Route::delete('/clubes/{id}/cancelar-postulacion', [App\Http\Controllers\ClubController::class, 'cancelarPostulacion'])->name('clubes.cancelar_postulacion');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';