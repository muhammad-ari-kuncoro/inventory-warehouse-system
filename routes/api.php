<?php

use App\Http\Controllers\api\ConsumableAPIController;
use App\Http\Controllers\api\DeliveryOrderAPIController;
use App\Http\Controllers\api\GoodReceivedAPIController;
use App\Http\Controllers\api\MaterialAPIController;
use App\Http\Controllers\api\ProyekAPIController;
use App\Http\Controllers\api\ToolsLoanCheckoutAPIController;
use App\Http\Controllers\api\UserAPIController;
use App\Http\Controllers\ApiDataProyekController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\MenuProjectController;
use App\Models\Consumables;
use App\Models\DeliveryOrder;
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

Route::delete('/delete/{id}',[ProyekAPIController::class, 'delete']);





Route::prefix('proyek')->group(function(){

    // Route API Data Proyek
    Route::post('/create-proyek',[ProyekAPIController::class, 'store']);
    // bug tolong di perbaiki masalah ketika mengakses malah muncul halaman
    Route::put('/update-proyek/{id}', [ProyekAPIController::class, 'update']);
    Route::delete('/delete-api-proyek', [ProyekAPIController::class, 'delete']);
});

Route::prefix('material')->group(function(){
    Route::post('/create-material',[MaterialAPIController::class, 'store']);
    Route::put('/update-api-material',[MaterialAPIController::class, 'update']);
    Route::delete('/delete-api-material',[MaterialAPIController::class,'delete']);
});



Route::prefix('consumable')->group(function(){
    Route::post('/create-consumable',[ConsumableAPIController::class, 'store']);
    Route::delete('/delete-api-consumable',[MaterialAPIController::class,'delete']);
});


Route::prefix('delivery-order')->group(function(){
    Route::post('/create-delivery-order',[DeliveryOrderAPIController::class, 'store']);
});

Route::prefix('good-received')->group(function(){
    Route::post('/create-good-received',[GoodReceivedAPIController::class, 'store']);
});





Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserAPIController::class, 'logout']);
    Route::get('/getIdProyek/{id}',[ApiDataProyekController::class, 'showID']);

    Route::prefix('checkout-checkin-tools')->group(function(){
        Route::post('/checkout-tools',[ToolsLoanCheckoutAPIController::class, 'store']);
    });

});
