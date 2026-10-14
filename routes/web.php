<?php

use Illuminate\Support\Facades\Route;
use App\Http\resource\views\TestView;
use App\Http\Controllers\PhotosController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});


//Route::view('/', 'welcome')->name('home');
Route::view('/', "accueil") -> name("home");

Route::view('photos', "photos") -> name("photos");
Route::view('trombinoscope', "trombinoscope") -> name("trombinoscope");
Route::view('administration', "administration") -> name("administration");

Route::delete('photos/{photo}', [PhotosController::class, "destroy"])
    -> middleware('auth')
    -> middleware('can:photos.delete');

Route::get("/hello", function(){
    return "Vive la France !";
});

require __DIR__.'/settings.php';
