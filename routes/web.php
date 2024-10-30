<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
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
      Route::get('/menu_project', [MenuProjectController::class, 'index'])->name('index.menu_project');
      Route::post('/tambah',[MenuProjectController::class, 'store'])->name('tambah.menu_project');
      Route::get('/edit_project{id}/edit', [MenuProjectController::class, 'edit'])->name('edit_project.edit');
      Route::patch('/edit_project{id}/update', [MenuProjectController::class, 'update'])->name('edit_project.update');



    // Route Logout
    Route::post('/logout',[DashboardController::class, 'logout'])->name('logout_dashboard');
    Route::get('/logout',[DashboardController::class, 'logout'])->name('logout');

});

