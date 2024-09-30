<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/t', function () {
    return view('template.admin_home');
});

Route::get('/', function () {
    return view('auth.login');
});



Route::get('admin/reset',[\App\Http\Controllers\ResetController::class,'reset_database'])->name('reset.database');

Route::get('/insertAd',[\App\Http\Controllers\AuthController::class,'insertAd']);
Route::get('/insertPro',[\App\Http\Controllers\PropController::class,'insertPrp']);

Route::get('/admin/login',[\App\Http\Controllers\AuthController::class,'login'])->name('auth.login');
Route::post('/admin/login',[\App\Http\Controllers\AuthController::class,'doLogin'])->name('auth.doLogin');
Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');


Route::get('/cli/login',[\App\Http\Controllers\CliController::class,'loginCli'])->name('auth.loginCli');
Route::post('/cli/login',[\App\Http\Controllers\CliController::class,'doLoginCli'])->name('auth.doLoginCli');

Route::get('/insertNote',[\App\Http\Controllers\AuthController::class,'insertNote'])->name('admin.ajout_note');
Route::post('/insertNote',[\App\Http\Controllers\AuthController::class,'doInsertNote'])->name('admin.insert_note');



Route::match(['GET', 'POST'], '/liste_etudiant',[\App\Http\Controllers\AuthController::class, 'filtre'])->name('admin.filtre');
Route::get('/semestre/{numetu}',[\App\Http\Controllers\AuthController::class,'listeSemestre'])->name('semestre.liste');

Route::get('/etudiant/note/{ids}/{etu}',[\App\Http\Controllers\AuthController::class,'noteSemestre'])->name('etudiant.note');
Route::get('/etude/note/{ids}/{etu}',[\App\Http\Controllers\CliController::class,'noteSemestre'])->name('etude.note');

 Route::get('/admin/import/data',[\App\Http\Controllers\ImportController::class,'index']);
 Route::post('/admin/import/data',[\App\Http\Controllers\ImportController::class,'importData']);

 Route::get('/nombre/etudiant',[\App\Http\Controllers\AuthController::class,'getNombreEtudiant'])->name('admin.nbr_etudiant');
 Route::get('/total_credit/etudiant',[\App\Http\Controllers\AuthController::class,'getAdmis'])->name('admin.total');

 Route::get('/admis/etudiant',[\App\Http\Controllers\AuthController::class,'getEtuAdmis'])->name('admis.etudiant');
 Route::get('/non_admis/etudiant',[\App\Http\Controllers\AuthController::class,'getEtuNonAdmis'])->name('non_admis.etudiant');

 Route::get('/liste/licence/{ids}',[\App\Http\Controllers\AuthController::class,'ListeLicence'])->name('licence.etudiant');

 
 Route::get('/listeRelever/licence/{an}/{etu}',[\App\Http\Controllers\AuthController::class,'ListeRelever'])->name('releverAnnee.etudiant');
