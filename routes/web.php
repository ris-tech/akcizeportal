<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KlijentiController;
use App\Http\Controllers\KnjigovodjaController;
use App\Http\Controllers\BankeController;
use App\Http\Controllers\PoreskaFilijalaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'edit'])->name('edit');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('klijenti', KlijentiController::class);
    Route::resource('knjigovodja', KnjigovodjaController::class);
    Route::resource('banke', BankeController::class);
    Route::resource('poreskafilijala', PoreskaFilijalaController::class);
});