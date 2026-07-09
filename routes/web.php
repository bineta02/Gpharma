<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\CategorieController; 
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\AchatController;

// Page de connexion
Route::get('/sign-in', [Authcontroller::class, 'verification'])->name('login');
Route::post('/sign-in', [Authcontroller::class, 'login']);

Route::middleware('auth')->group(function (){
Route::get('/', function (){
    return view('home');  
})->name('dashboard');
Route::get('/logout', [Authcontroller::class, 'logout'])->name('logout');       
Route::resource('users', UserController::class);

// Route pour les catégories
Route::resource('categories', CategorieController::class);

// Route pour les produits
Route::resource('produits', ProduitController::class);

// Route pour les fournisseurs
Route::resource('fournisseurs', FournisseurController::class);
// Route pour les achats
Route::patch('achats/{id}/receptionner', [AchatController::class, 'receptionner'])->name('achats.receptionner');
Route::patch('achats/{id}/annuler', [AchatController::class, 'annuler'])->name('achats.annuler');
Route::resource('achats', AchatController::class);





});