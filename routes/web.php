<?php

use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\EnseignersController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\UtilisateursController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::view('/', 'accueil')->name('home');

Route::get('photos', [PhotosController::class, 'index'])
    ->middleware(['auth', 'can:photos.view'])
    ->name('photos');

Route::prefix('photos/gestion')
    ->name('photos.')
    ->middleware(['auth', 'can:administration.view'])
    ->group(function () {
        Route::get('/', [PhotosController::class, 'manage'])
            ->middleware('can:photos.view')
            ->name('manage');
        Route::get('create', [PhotosController::class, 'create'])
            ->middleware('can:photos.create')
            ->name('create');
        Route::post('/', [PhotosController::class, 'store'])
            ->middleware('can:photos.create')
            ->name('store');
        Route::get('{photo}/edit', [PhotosController::class, 'edit'])
            ->middleware('can:photos.update')
            ->name('edit');
        Route::put('{photo}', [PhotosController::class, 'update'])
            ->middleware('can:photos.update')
            ->name('update');
        Route::delete('{photo}', [PhotosController::class, 'destroy'])
            ->middleware('can:photos.delete')
            ->name('destroy');
    });
Route::get('photos/{photo}/fichier', [PhotosController::class, 'file'])
    ->middleware('auth')
    ->name('photos.file');

Route::get('trombinoscope', [PhotosController::class, 'trombinoscope'])
    ->middleware(['auth', 'can:trombinoscope.view'])
    ->name('trombinoscope');

Route::get('administration', [AdministrationController::class, 'index'])
    ->middleware(['auth', 'can:administration.view'])
    ->name('administration');

Route::prefix('administration')->name('administration.')->middleware('auth')->group(function () {
    Route::get('classes', [ClassesController::class, 'index'])
        ->middleware('can:administration.view')
        ->name('classes.index');
    Route::post('classes', [ClassesController::class, 'store'])
        ->middleware('can:administration.create')
        ->name('classes.store');
    Route::put('classes/{classe}', [ClassesController::class, 'update'])
        ->middleware('can:administration.update')
        ->name('classes.update');
    Route::delete('classes/{classe}', [ClassesController::class, 'destroy'])
        ->middleware('can:administration.delete')
        ->name('classes.destroy');

    Route::get('utilisateurs', [UtilisateursController::class, 'index'])
        ->middleware('can:administration.view')
        ->name('utilisateurs.index');
    Route::get('utilisateurs/create', [UtilisateursController::class, 'create'])
        ->middleware('can:administration.create')
        ->name('utilisateurs.create');
    Route::post('utilisateurs', [UtilisateursController::class, 'store'])
        ->middleware('can:administration.create')
        ->name('utilisateurs.store');
    Route::get('utilisateurs/{utilisateur}/edit', [UtilisateursController::class, 'edit'])
        ->middleware('can:administration.update')
        ->name('utilisateurs.edit');
    Route::put('utilisateurs/{utilisateur}', [UtilisateursController::class, 'update'])
        ->middleware('can:administration.update')
        ->name('utilisateurs.update');
    Route::delete('utilisateurs/{utilisateur}', [UtilisateursController::class, 'destroy'])
        ->middleware('can:administration.delete')
        ->name('utilisateurs.destroy');

    Route::get('enseigners', [EnseignersController::class, 'index'])
        ->middleware('can:administration.view')
        ->name('enseigners.index');
    Route::post('enseigners', [EnseignersController::class, 'store'])
        ->middleware('can:administration.create')
        ->name('enseigners.store');
    Route::delete('enseigners/{utilisateur}/{classe}', [EnseignersController::class, 'destroy'])
        ->middleware('can:administration.delete')
        ->name('enseigners.destroy');
});

Route::get('/hello', function () {
    return 'Vive la France !';
});

require __DIR__.'/settings.php';
