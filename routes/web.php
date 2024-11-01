<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MenuProjectController;

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
Route::get('/login',[LoginController::class,'index']);
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
    });

    //   Route Materials
    Route::prefix('material')->name('material.')->group(function(){
        Route::get('/',[MaterialController::class, 'index'])->name('index');
        Route::post('create',[MaterialController::class, 'store'])->name('create');
        Route::get('edit/{id}',[MaterialController::class, 'edit'])->name('edit');
    });



    // Route Logout
    Route::post('/logout',[DashboardController::class, 'logout'])->name('logout_dashboard');
    Route::get('/logout',[DashboardController::class, 'logout'])->name('logout');

});

