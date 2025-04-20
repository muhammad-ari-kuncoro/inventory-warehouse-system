<?php

use App\Http\Controllers\api\ConsumableAPIController;
use App\Http\Controllers\Api\ConsumableIssuanceAPIController;
use App\Http\Controllers\api\DeliveryOrderAPIController;
use App\Http\Controllers\api\GoodReceivedAPIController;
use App\Http\Controllers\api\MaterialAPIController;
use App\Http\Controllers\api\ProyekAPIController;
use App\Http\Controllers\api\ToolsAPIController;
use App\Http\Controllers\api\ToolsLoanCheckoutAPIController;
use App\Http\Controllers\api\UserAPIController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\api\MaterialIssuanceAPIController;
use App\Http\Controllers\api\ToolsCheckInController;
use App\Http\Controllers\api\ToolsCheckoutController;
use App\Http\Controllers\GoodsReceivedController;
use App\Http\Controllers\ToolsController;
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




// Route API menu proyek
Route::prefix('proyek')->group(function(){

    Route::middleware('auth:sanctum')->group(function () {
        // Route API Data Proyek
        Route::get('/getdata-proyek',[ProyekAPIController::class, 'getdataAll']);
        Route::get('/getid-data/{id}',[ProyekAPIController::class, 'getdataID']);

        Route::post('/create-project',[ProyekAPIController::class, 'store']);

        Route::get('/edit-project/{id}',[ProyekAPIController::class, 'edit']);
        Route::put('/update-project/{id}', [ProyekAPIController::class, 'update']);


    });
});

//Route API Menu Material
Route::prefix('material')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/getdata-material',[MaterialAPIController::class, 'getdataAll']);
        Route::get('/getid-data/{id}',[MaterialAPIController::class, 'getdataID']);

        Route::post('/create-material',[MaterialAPIController::class, 'store']);
        Route::put('/update-api-material/{id}',[MaterialAPIController::class, 'update']);

    });
});


// Route API Menu Tools
Route::prefix('tools')->group(function(){

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/create-tools',[ToolsAPIController::class, 'store']);
        Route::get('/getdata-tools',[ToolsAPIController::class, 'getdataAll']);


        Route::get('/getid-data/{id}',[ToolsAPIController::class, 'getdataID']);
        Route::put('/update-api-tools/{id}',[ToolsAPIController::class,'update']);
        // Route::put('/update-api-material',[ToolsController::class, 'update']);
        // Route::delete('/delete-api-material',[MaterialAPIController::class,'delete']);

    });
});


// Route: API Consumbale
Route::prefix('consumable')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/create-consumable',[ConsumableAPIController::class, 'store']);
        Route::put('/update-api-consumable',[ConsumableAPIController::class, 'update']);
        Route::delete('/delete-api-consumable',[MaterialAPIController::class,'delete']);
    });
});



// Route: Delivery Order
Route::prefix('delivery-order')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/create-delivery-order-store-item',[DeliveryOrderAPIController::class, 'storeItem']);
        Route::post('/create-delivery-order-store',[DeliveryOrderAPIController::class, 'store']);
        Route::post('/delete-draft',[DeliveryOrderAPIController::class, 'deleteDraft']);
    });
});


// Route: Good Received
Route::prefix('good-received')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/data-good-received-all',[GoodsReceivedController::class, 'dataALL']);

        Route::post('/create-good-received-store',[GoodReceivedAPIController::class, 'store']);
        Route::post('/create-good-received',[GoodReceivedAPIController::class, 'storeGoodReceived']);
        Route::post('/create-good-received-store-item-update/{id}',[GoodReceivedAPIController::class, 'store']);

    });
});

// Route: Consumable Issuance
Route::prefix('consumable-issuance')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/create-consumable-issuance',[ConsumableIssuanceAPIController::class, 'store']);
        Route::delete('/delete-consumable-issuance/{id}',[ConsumableIssuanceAPIController::class,'delete']);
    });
});

// Route: material Issuance
Route::prefix('material-issuance')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/create-material-issuance',[MaterialIssuanceAPIController::class, 'store']);
        Route::delete('/delete-material-issuance/{id}',[MaterialIssuanceAPIController::class,'delete']);
    });
});

// Route: Peminjaman Alat
Route::prefix('tools-check-out-api')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/data-tools-check-out',[ToolsCheckoutController::class, 'index']);
        Route::post('/create-data-tools-checkout',[ToolsCheckoutController::class, 'store']);
    });
});


// Route: Pengembalian Alat
Route::prefix('tools-check-in-api')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/data-tools-check-in',[ToolsCheckInController::class, 'index']);
        Route::post('/data-tools-check-in',[ToolsCheckInController::class, 'store']);
    });
});













Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserAPIController::class, 'logout']);
    Route::get('/getIdProyek/{id}',[ProyekAPIController::class, 'showID']);

    Route::prefix('checkout-checkin-tools')->group(function(){
        Route::post('/checkout-tools',[ToolsLoanCheckoutAPIController::class, 'store']);
    });

});
