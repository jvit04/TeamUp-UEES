<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\EventoAcademicoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas principales de TeamUp-UEES
|--------------------------------------------------------------------------
|
| Estas rutas pertenecen a la rama inicio-eventos-academicos.
| Usan el layout compartido y muestran publicaciones/eventos.
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [InicioController::class, 'index'])->name('inicio');

    Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');

    Route::get('/eventos-academicos', [EventoAcademicoController::class, 'index'])
        ->name('eventos-academicos.index');

    Route::get('/eventos-academicos/{id}', [EventoAcademicoController::class, 'show'])
        ->name('eventos-academicos.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';