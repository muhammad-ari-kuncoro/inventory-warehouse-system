<?php

use App\Http\Controllers\ConsumableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\GoodsReceivedController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MenuProjectController;
use App\Http\Controllers\ShippingItemController;
use App\Http\Controllers\ToolsController;
use Faker\Guesser\Name;

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

      // Route Project Menu
    Route::prefix('project')->name('project.')->group(function(){
        Route::get('/', [MenuProjectController::class, 'index'])->name('index');
        Route::post('create',[MenuProjectController::class, 'store'])->name('create');
        Route::get('edit/{id}', [MenuProjectController::class, 'edit'])->name('edit');
        Route::patch('update/{id}', [MenuProjectController::class, 'update'])->name('update');
        Route::get('/search',[MenuProjectController::class, 'index'])->name('search');


    });
    //   Route Stock (Menu Material , Menu Consumable , Menu Tools)
    Route::prefix('material')->name('material.')->group(function(){
        Route::get('/',[MaterialController::class, 'index'])->name('index');
        Route::post('create',[MaterialController::class, 'store'])->name('create');
        Route::get('edit/{id}',[MaterialController::class, 'edit'])->name('edit');
        Route::patch('update{id}',[MaterialController::class, 'update'])->name('update');
        Route::get('/search',[MaterialController::class, 'index'])->name('search');

    });

    Route::prefix('consumable')->name('consumable.')->group(function(){
        Route::get('/',[ConsumableController::class, 'index'])->name('index');
        Route::post('create',[ConsumableController::class, 'store'])->name('create');
        Route::get('edit/{id}',[ConsumableController::class, 'edit'])->name('edit');
        Route::patch('update{id}',[ConsumableController::class, 'update'])->name('update');

    });

    Route::prefix('tools')->name('tools.')->group(function(){
        Route::get('/',[ToolsController::class, 'index'])->name('index');
        Route::post('create',[ToolsController::class, 'store'])->name('create');
        Route::get('edit/{id}',[ToolsController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[ToolsController::class, 'update'])->name('update');
    });
    // End Route Stok

    Route::prefix('good-received')->name('good-received.')->group(function(){
        Route::get('/',[GoodsReceivedController::class, 'index'])->name('index');
        Route::get('create',[GoodsReceivedController::class, 'create'])->name('create');
        Route::post('store',[GoodsReceivedController::class, 'store'])->name('store');
        Route::get('edit/{id}',[GoodsReceivedController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[GoodsReceivedController::class, 'update'])->name('update');


    });

    Route::prefix('delivery-order')->name('delivery-order.')->group(function(){
        Route::get('/',[DeliveryOrderController::class, 'index'])->name('index');
        Route::get('create',[DeliveryOrderController::class, 'create'])->name('create');
        Route::post('store',[DeliveryOrderController::class, 'store'])->name('store');
        Route::get('edit/{id}',[DeliveryOrderController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[DeliveryOrderController::class, 'update'])->name('update');

    });

    Route::prefix('shipping-items')->name('shipping-items.')->group(function(){
        Route::get('/',[ShippingItemController::class, 'index'])->name('index');
        Route::get('/create',[ShippingItemController::class, 'create'])->name('create');


    });






    // Route Logout
    Route::post('/logout',[DashboardController::class, 'logout'])->name('logout_dashboard');
    Route::get('/logout',[DashboardController::class, 'logout'])->name('logout');

});

