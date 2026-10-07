<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\resource\views\TestView;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});


//Route::view('/', 'welcome')->name('home');
Route::view('/', "accueil") -> name("home");
Route::view('produits', "produits") -> name("produitsName");
Route::view('contact', "contact") -> name("contactName");


Route::get("/hello", function(){
    return "Vive la France !";
});

require __DIR__.'/settings.php';
