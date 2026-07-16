<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategorieController; 
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\AchatController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ProfilController;

// Page de connexion
Route::get('/sign-in', [Authcontroller::class, 'verification'])->name('login');
Route::post('/sign-in', [Authcontroller::class, 'login']);

Route::middleware('auth')->group(function (){
Route::get('/', function (){
    return view('home');  
})->name('dashboard');
Route::get('/logout', [Authcontroller::class, 'logout'])->name('logout');       
Route::resource('users', UserController::class);



// Routes pour le Profil Personnel
Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');


Route::post('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');




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
// Routes pour les ventes (Caisse / POS)
Route::patch('ventes/{id}/annuler', [VenteController::class, 'annuler'])->name('ventes.annuler');
Route::resource('ventes', VenteController::class);
// Routes pour les clients
Route::resource('clients', ClientController::class);
// Route pour les rapports
Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
Route::get('/rapports/export-excel', [RapportController::class, 'exportExcel'])->name('rapports.excel');




});