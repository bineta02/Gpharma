<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
// Page de connexion
Route::get('/sign-in', [Authcontroller::class, 'verification'])->name('login');
Route::post('/sign-in', [Authcontroller::class, 'login']);

Route::middleware('auth')->group(function (){
Route::get('/', function (){
    return view('home');  
})->name('dashboard');
Route::get('/logout', [Authcontroller::class, 'logout'])->name('logout');       
Route::resource('users', UserController::class);


});