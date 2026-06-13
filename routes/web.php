<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConcursoController; 
use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
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

    // Rutas de Clubes
    Route::get('/clubes', [ClubController::class, 'index'])->name('clubes.index');
    Route::get('/clubes/{id}', [ClubController::class, 'show'])->name('clubes.show');
    Route::post('/clubes/{id}/postular', [ClubController::class, 'postularClub'])->name('clubes.postular');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
