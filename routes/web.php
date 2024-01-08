<?php


use App\Http\Controllers\AvisController;
use App\Http\Controllers\ChapitreController;
use App\Http\Controllers\HistoiresController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\UserController;

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

Route::get('/', [HistoiresController::class, "index"])->name("histoires.index");
Route::get('/contact', [EquipeController::class,'contact'])->name("contact");
Route::post('/contact',[EquipeController::class,'contactShow'])->name("contactShow");


Route::get('/chapitre/{id}/start', [ChapitreController::class, "premierChapitre"])->name("histoire.start");


Route::get('/profil/{id}', [UserController::class, 'profil'])->name('user.profil');

Route::post('/updateAvatar/{id}',[UserController::class,'changeAvatar'])->name("user.avatarUpdate");
Route::get('/equipe', [EquipeController::class,'index'])->name("equipe_index");
Route::get("/chapitre/{id}", [ChapitreController::class, "afficherChapitre"])->name("chapitre.show");

Route::post('/histoire/{id}',[AvisController::class,"store"])->name("avis.store");
Route::post('/histoire/del/{id}',[AvisController::class,"delete"])->name("avis.delete");
Route::get('/histoire/{id}/commentaire/edit',[AvisController::class,"edit"])->name("avis.edit");
Route::post('/histoire/edit/{id}',[AvisController::class,"update"])->name("avis.update");

Route::get('/chapitre/{id}/edit',[ChapitreController::class,"edit"])->name("chapitre.edit");
Route::post('/chapitre/{id}',[ChapitreController::class,"update"])->name("chapitre.update");

Route::post('/link/delete/{source_id}/{destination_id}', [ChapitreController::class,'deleteLink'])->name("link.delete");
//Route::get('/create/histoire/', [HistoiresController::class, 'create'])->name("histoire.create");
//
//Route::get('/histoire/{id}', [HistoiresController::class,'show'])->name("histoire.show");

Route::resource("histoire",HistoiresController::class);

Route::post('/histoire/{id}/edit/link', [HistoiresController::class,'link'])->name("histoire.link");

Route::post('/histoire/{id}/edit/public',[HistoiresController::class,"setPublic"])->name("histoire.public");

Route::post('/histoire/{id}/edit/private',[HistoiresController::class,"setPrivate"])->name("histoire.private");

Route::get('/histore/{id}/editHistory', [HistoiresController::class, "editHistory"])->name('histoire.editHistory');

Route::post('/histore/{id}/update', [HistoiresController::class, "updateHistory"])->name('histoire.updateHistory');

Route::get('/interview', function (){
   return view("interview",["titre"=>"Interview"]);
})->name('interview');