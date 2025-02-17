<?php

use App\Http\Controllers\api\MaterialAPIController;
use App\Http\Controllers\api\ProyekAPIController;
use App\Http\Controllers\api\UserAPIController;
use App\Http\Controllers\ApiDataProyekController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\MenuProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [UserAPIController::class, 'login']);

Route::post('/createProyek',[ProyekAPIController::class, 'store']);
Route::put('/update/{id}', [ProyekAPIController::class, 'update']);



Route::prefix('project')->name('projectApi.')->group(function(){
    // bug tolong di perbaiki masalah ketika mengakses malah muncul halaman
    Route::delete('/delete/{id}',[ProyekAPIController::class, 'delete']);
});

Route::prefix('material')->name('materialApi.')->group(function(){
    // bug
    Route::post('/create',[MaterialAPIController::class, 'store']);

});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserAPIController::class, 'logout']);
    Route::get('/getIdProyek/{id}',[ApiDataProyekController::class, 'showID']);



});
