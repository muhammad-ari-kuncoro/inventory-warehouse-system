<?php

use App\Http\Controllers\api\CheckinToolsRentalAPIController;
use App\Http\Controllers\CheckInToolsController;
use App\Http\Controllers\CheckOutToolsController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\ConsumableIssuanceController;
use App\Http\Controllers\CreatedUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\GoodsReceivedController;
use App\Http\Controllers\HydrotestMaterialLendingController;
use App\Http\Controllers\MachinesController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialIssuanceController;
use App\Http\Controllers\MaterialTemporaryController;
use App\Http\Controllers\MenuProjectController;
use App\Http\Controllers\ShippingItemController;
use App\Http\Controllers\ToolsController;
use App\Models\ConsumableIssuance;
use App\Models\Consumables;
use App\Models\HydrotestMaterialLending;
use App\Models\MaterialTemporary;
use Faker\Guesser\Name;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route Login Dan Register Page
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login_page',[LoginController::class,'authentication'])->name('login_page_dasboard');

Route::middleware('auth')->group(function (){
    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/viewProfile',[DashboardController::class, 'viewProfil'])->name('viewProfile');

      // Route Project Menu
    Route::prefix('project')->name('project.')->group(function(){
        Route::get('/', [MenuProjectController::class, 'index'])->name('index');
        Route::post('create',[MenuProjectController::class, 'store'])->name('create');
        Route::get('edit/{id}', [MenuProjectController::class, 'edit'])->name('edit');
        Route::patch('update/{id}', [MenuProjectController::class, 'update'])->name('update');
        Route::get('/search',[MenuProjectController::class, 'index'])->name('search');
        Route::get('/detail/{id}',[MenuProjectController::class,'show'])->name('detail');


    });

    Route::prefix('userData')->name('userData.')->group(function (){
        Route::get('/',[CreatedUserController::class, 'index'])->name('index');
        Route::post('/create',[CreatedUserController::class, 'store'])->name('create');
        Route::get('read-user/{id}',[CreatedUserController::class, 'show'])->name('read-user');
        Route::put('update-image-user/{id}',[CreatedUserController::class, 'update'])->name('update-image-user');
    });


    //   Route Stock (Menu Material , Menu Consumable , Menu Tools)
    Route::prefix('material')->name('material.')->group(function(){
        Route::get('/',[MaterialController::class, 'index'])->name('index');
        Route::post('create',[MaterialController::class, 'store'])->name('create');
        Route::get('edit/{id}',[MaterialController::class, 'edit'])->name('edit');
        Route::patch('update{id}',[MaterialController::class, 'update'])->name('update');
        Route::get('/search',[MaterialController::class, 'index'])->name('search');
        Route::post('/import',[MaterialController::class, 'import'])->name('import');

    });

    Route::prefix('consumable')->name('consumable.')->group(function(){
        Route::get('/',[ConsumableController::class, 'index'])->name('index');
        Route::post('create',[ConsumableController::class, 'store'])->name('create');
        Route::get('edit/{id}',[ConsumableController::class, 'edit'])->name('edit');
        Route::patch('update{id}',[ConsumableController::class, 'update'])->name('update');
        Route::post('/import',[ConsumableController::class, 'import'])->name('import');

    });

    Route::prefix('tools')->name('tools.')->group(function(){
        Route::get('/',[ToolsController::class, 'index'])->name('index');
        Route::post('create',[ToolsController::class, 'store'])->name('create');
        Route::get('edit/{id}',[ToolsController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[ToolsController::class, 'update'])->name('update');
        Route::post('/import',[ToolsController::class, 'import'])->name('import');
    });


    Route::prefix('material-temporary')->name('material-temporary.' )->group(function(){
        Route::get('/',[MaterialTemporaryController::class, 'index'])->name('index');
        Route::post('create',[MaterialTemporaryController::class, 'store'])->name('create');
        Route::get('edit/{id}',[MaterialTemporaryController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[MaterialTemporaryController::class, 'update'])->name('update');
    });



    Route::prefix('machine')->name('machine.')->group(function(){
        Route::get('/',[MachinesController::class, 'index'])->name('index');
        Route::post('/create',[MachinesController::class, 'store'])->name('create');
        Route::get('edit/{id}',[MachinesController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[MachinesController::class, 'update'])->name('update');

    });

    // End Route Stok
    Route::prefix('good-received')->name('good-received.')->group(function(){
        Route::get('/',[GoodsReceivedController::class, 'index'])->name('index');
        Route::get('create',[GoodsReceivedController::class, 'create'])->name('create');
        Route::post('store',[GoodsReceivedController::class, 'store'])->name('store');
        Route::post('store/item',[GoodsReceivedController::class, 'storeItem'])->name('store.item');
        Route::post('store/item/update/{id}',[GoodsReceivedController::class, 'storeItemUpdate'])->name('store.item.update');
        Route::post('delete-draft',[GoodsReceivedController::class, 'deleteDraft'])->name('delete-draft');
        Route::get('edit/{id}',[GoodsReceivedController::class, 'edit'])->name('edit');
        Route::get('show/{id}',[GoodsReceivedController::class, 'show'])->name('show');
        Route::patch('update/{id}',[GoodsReceivedController::class, 'update'])->name('update');
        Route::delete('destroy/{id}',[GoodsReceivedController::class,'destroy'])->name('destroy');
        Route::delete('delete/detail/{id}',[GoodsReceivedController::class,'destroyDetail'])->name('delete-detail');
    });

    Route::prefix('delivery-order')->name('delivery-order.')->group(function(){
        Route::get('/',[DeliveryOrderController::class, 'index'])->name('index');
        Route::get('create',[DeliveryOrderController::class, 'create'])->name('create');
        Route::post('store',[DeliveryOrderController::class, 'store'])->name('store');
        Route::post('store/item',[DeliveryOrderController::class, 'storeItem'])->name('store.item');
        Route::post('delete-draft',[DeliveryOrderController::class, 'deleteDraft'])->name('delete-draft');
        Route::get('edit/{id}',[DeliveryOrderController::class, 'edit'])->name('edit');
        Route::get('print-pdf/{id}',[DeliveryOrderController::class, 'printPDF'])->name('print-pdf');
        Route::get('show/{id}',[DeliveryOrderController::class, 'show'])->name('show');
        Route::patch('update/{id}',[DeliveryOrderController::class, 'update'])->name('update');
        Route::patch('update-detail/{id}',[DeliveryOrderController::class, 'updateDetail'])->name('update-detail');
        Route::get('detail-updating/{id}',[DeliveryOrderController::class, 'detailUpdate'])->name('detail-updating');
        Route::delete('delete-per-draft/{id}',[DeliveryOrderController::class, 'deletePerDraft'])->name('delete-per-draft');

    });

    Route::prefix('shipping-items')->name('shipping-items.')->group(function(){
        Route::get('/',[ShippingItemController::class, 'index'])->name('index');
        Route::get('/create',[ShippingItemController::class, 'create'])->name('create');
        Route::post('store',[ShippingItemController::class, 'store'])->name('store');
        Route::post('store/item',[ShippingItemController::class, 'storeItem'])->name('store.item');
        Route::get('edit/{id}',[ShippingItemController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[ShippingItemController::class,'update'])->name('update');

    });

    Route::prefix('consumable-issuance')->name('consumable-issuance.')->group(function(){
        Route::get('/',[ConsumableIssuanceController::class, 'index'])->name('index');
        Route::get('create',[ConsumableIssuanceController::class, 'create'])->name('create');
        Route::post('store',[ConsumableIssuanceController::class, 'store'])->name('store');
        Route::get('detail/{id}',[ConsumableIssuanceController::class, 'show'])->name('show');

    });


    Route::prefix('material-issuance')->name('material-issuance.')->group(function(){
        Route::get('/',[MaterialIssuanceController::class, 'index'])->name('index');
        Route::get('create',[MaterialIssuanceController::class, 'create'])->name('create');
        Route::post('store',[MaterialIssuanceController::class, 'store'])->name('store');
        Route::get('detail/{id}',[MaterialIssuanceController::class, 'show'])->name('show');

    });

    Route::prefix('check-out-tools')->name('check-out-tools.')->group(function(){

        Route::get('/',[CheckOutToolsController::class, 'index'])->name('index');
        Route::get('create',[CheckOutToolsController::class, 'create'])->name('create');
        Route::post('store',[CheckOutToolsController::class, 'store'])->name('store');
        Route::get('detail/{id}',[CheckOutToolsController::class, 'show'])->name('show');

    });

    Route::prefix('check-in-tools')->name('check-in-tools.')->group(function(){

        Route::get('/',[CheckInToolsController::class, 'index'])->name('index');
        Route::get('create',[CheckInToolsController::class, 'create'])->name('create');
        Route::post('store',[CheckInToolsController::class, 'store'])->name('store');
        Route::get('detail/{id}',[CheckInToolsController::class, 'show'])->name('show');
        Route::post('/checkin/{id}', [CheckInToolsController::class, 'checkin'])->name('checkin');

    });

    Route::prefix('hydrotest-material-lending')->name('hydrotest-material-lending.')->group(function(){
        Route::get('/',[HydrotestMaterialLendingController::class, 'index'])->name('index');
        Route::get('create',[HydrotestMaterialLendingController::class, 'create'])->name('create');
        Route::post('store',[HydrotestMaterialLendingController::class,'store'])->name('store');

    });







    // Route Logout
    Route::post('/logout',[DashboardController::class, 'logout'])->name('logout_dashboard');
    Route::get('/logout',[DashboardController::class, 'logout'])->name('logout');

});

