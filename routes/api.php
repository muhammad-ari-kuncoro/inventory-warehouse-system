<?php

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
Route::post('/loginAPI', [LoginUserController::class, 'authentication']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logoutAPI', [LoginUserController::class, 'logout']);

    // Route Admin (role 1)
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Welcome Admin']);
        });
        Route::prefix('project')->name('project.')->group(function(){

            Route::get('/project/detail/{id}', [ApiDataProyekController::class, 'show']);

        });
    });

    // Route Warehouse Admin (role 2)
    Route::middleware('role:warehouse')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Welcome Warehouse Admin']);
        });
    });

    // Route Produksi (role 3)
    Route::middleware('role:produksi')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Welcome Production Team']);
        });
    });
});
