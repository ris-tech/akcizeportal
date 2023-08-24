<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KlijentiController;
use App\Http\Controllers\KnjigovodjaController;
use App\Http\Controllers\BankeController;
use App\Http\Controllers\DokumentaController;
use App\Http\Controllers\PEPController;
use App\Http\Controllers\PoreskaFilijalaController;
use App\Http\Controllers\UgovorController;
use App\Models\Dokumenta;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/dokumenta/sendMail', [DokumentaController::class, 'sendMail'])->name('dokumenta.sendMail');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('klijenti', KlijentiController::class);
    Route::resource('knjigovodja', KnjigovodjaController::class);
    Route::resource('banke', BankeController::class);
    Route::resource('poreskafilijala', PoreskaFilijalaController::class);
    Route::resource('ugovor', UgovorController::class);
    Route::resource('dokumenta', DokumentaController::class);
    Route::resource('pep', PEPController::class);
});
