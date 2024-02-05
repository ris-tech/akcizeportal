<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KlijentiController;
use App\Http\Controllers\KnjigovodjaController;
use App\Http\Controllers\BankeController;
use App\Http\Controllers\DobavljaciController;
use App\Http\Controllers\DokumentaController;
use App\Http\Controllers\GorivoController;
use App\Http\Controllers\KvartaliController;
use App\Http\Controllers\NaloziController;
use App\Http\Controllers\PEPController;
use App\Http\Controllers\PoreskaFilijalaController;
use App\Http\Controllers\RadnaListaController;
use App\Http\Controllers\UgovorController;
use App\Http\Controllers\VozilaController;
use App\Http\Controllers\IzvestajiController;
use App\Http\Controllers\IzvestajOPlacanjuController;
use App\Models\Dokumenta;
use App\Models\Gorivo;
use App\Models\Vozila;

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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::post('/dokumenta/sendMail', [DokumentaController::class, 'sendMail'])->name('dokumenta.sendMail');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('klijenti', KlijentiController::class);
    Route::resource('knjigovodja', KnjigovodjaController::class);
    Route::resource('banke', BankeController::class);
    Route::resource('poreskafilijala', PoreskaFilijalaController::class);
    Route::resource('ugovor', UgovorController::class);
    Route::post('/dokumenta/retrieveFile', [DokumentaController::class, 'retrieveFile'])->name('dokumenta.retrieveFile');
    Route::post('/dokumenta/upload/{id}', [DokumentaController::class, 'upload'])->name('dokumenta.upload');
    Route::get('/dokumenta/showDokumenta/{id}/{docType}/{docTypeName}', [DokumentaController::class, 'showDokumenta'])->name('dokumenta.showDokumenta');
    Route::post('/dokumenta/processPDFs', [DokumentaController::class, 'processPDFs'])->name('dokumenta.processPDFs');
    Route::post('/dokumenta/getProc', [DokumentaController::class, 'getProc'])->name('dokumenta.getProc');
    Route::post('/dokumenta/storeFiles', [DokumentaController::class, 'storeFiles'])->name('dokumenta.storeFiles');
    Route::post('/dokumenta/deleteFile', [DokumentaController::class, 'deleteFile'])->name('dokumenta.deleteFile');
    Route::resource('dokumenta', DokumentaController::class);
    Route::resource('pep', PEPController::class);
    Route::resource('gorivo', GorivoController::class);
    Route::resource('dobavljaci', DobavljaciController::class);
    Route::resource('kvartali', KvartaliController::class);
    Route::post('/nalozi/getKvartali', [NaloziController::class, 'getKvartali'])->name('nalozi.getKvartali');
    Route::resource('nalozi', NaloziController::class);
    Route::get('/radnalista/scan/{id}/{tip}/{tip_ime}', [RadnaListaController::class, 'scan'])->name('radnalista.scan');
    Route::get('/radnalista/selectScan/{id}', [RadnaListaController::class, 'selectScan'])->name('radnalista.selectScan');
    Route::get('/radnalista/extImg/{id}/{tip?}', [RadnaListaController::class, 'extImg'])->name('radnalista.extImg');
    Route::get('/radnalista/tabela/{id}/{tip?}/{tipId?}', [RadnaListaController::class, 'tabela'])->name('radnalista.tabela');
    Route::post('/radnalista/deleteFile', [RadnaListaController::class, 'deleteFile'])->name('radnalista.deleteFile');
    Route::post('/radnalista/retrieveFile', [RadnaListaController::class, 'retrieveFile'])->name('radnalista.retrieveFile');
    Route::post('/radnalista/finishScan', [RadnaListaController::class, 'finishScan'])->name('radnalista.finishScan');    
    Route::post('/radnalista/finishUnos', [RadnaListaController::class, 'finishUnos'])->name('radnalista.finishUnos');    
    Route::post('/radnalista/storeFiles', [RadnaListaController::class, 'storeFiles'])->name('radnalista.storeFiles');
    Route::post('/radnalista/processPDFs', [RadnaListaController::class, 'processPDFs'])->name('radnalista.processPDFs');
    Route::post('/radnalista/getProc', [RadnaListaController::class, 'getProc'])->name('radnalista.getProc');
    Route::resource('radnalista', RadnaListaController::class);
    Route::post('/vozila/addVozilo/{id}', [VozilaController::class, 'addVozilo'])->name('vozila.addVozilo');
    Route::post('/vozila/destroySaobracajnu/{id}', [VozilaController::class, 'destroySaobracajnu'])->name('vozila.destroySaobracajnu');
    Route::post('/vozila/destroyVozilo', [VozilaController::class, 'destroyVozilo'])->name('vozila.destroyVozilo');
    Route::post('/vozila/uploadSaobracajna/{id}', [VozilaController::class, 'uploadSaobracajna'])->name('vozila.uploadSaobracajna');
    Route::post('/vozila/upload/{id}', [VozilaController::class, 'upload'])->name('vozila.upload');
    Route::post('/vozila/getKvartal', [VozilaController::class, 'getKvartal'])->name('vozila.getKvartal');
    Route::post('/vozila/getVozilo', [VozilaController::class, 'getVozilo'])->name('vozila.getVozilo');
    Route::get('/vozila/{id}/{kvartal}', [VozilaController::class, 'show'])->name('vozila.show');
    Route::resource('vozila', VozilaController::class);
    Route::post('/izvestaji/sacuvajIzvestajPoVozilu', [IzvestajiController::class, 'sacuvajIzvestajPoVozilu'])->name('izvestaji.sacuvajIzvestajPoVozilu');
    Route::resource('izvestaji', IzvestajiController::class);
    Route::post('/izvestajOPlacanju/getBindDocs', [IzvestajOPlacanjuController::class, 'getBindDocs'])->name('izvestajOPlacanju.getBindDocs');
    Route::resource('izvestajOPlacanju', IzvestajOPlacanjuController::class);

});
