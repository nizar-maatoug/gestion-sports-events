<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EvennementSprotifController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class, 'login']);

 Route::middleware('auth:sanctum')->group(function(){
   Route::apiResource('events',EvennementSprotifController::class)->except('show');
   //...les autres routes authentifiés
   //categories...
}); 


Route::apiResource('events',EvennementSprotifController::class)->only("show");
