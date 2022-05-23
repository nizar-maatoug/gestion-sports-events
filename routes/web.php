<?php

use App\Http\Controllers\{
    CategorieController,
    HomeController,EvennementSportifController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/',HomeController::class)->name('home');

//Route::get('eventsportif/{eventSportif}', [EvennementSportifController::class, 'show'])->name('eventSportif.show');

Route::get('categories/{eventSportif}',[CategorieController::class,'index'])->name('categories.index');


/**
 * Middleware: Méthode 1
 */
/* Route::resource('events',EvennementSportifController::class, ['except' => ['show']])->middleware('auth');

Route::resource('events',EvennementSportifController::class, ['only' => ['show']]); */

/**
 * Middleware: Méthode 2
 */
/* Route::middleware(['auth'])->group(function () {
    Route::resource('events',EvennementSportifController::class, ['except' => ['show']]);
    //...les autres routes authentifiés
});
Route::resource('events',EvennementSportifController::class, ['only' => ['show']]); */

/**
 * Middleware: Méthode 3
 */
Route::middleware(['auth'])->group(function () {
    Route::resource('events',EvennementSportifController::class)->except('show');
    //...les autres routes authentifiés
});
Route::resource('events',EvennementSportifController::class)->only('show');