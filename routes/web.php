<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])->name('home');


Auth::routes();

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/user', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/adduser', [AdminController::class, 'adduser'])->name('add.user');
    Route::delete('/admin/deleteuser', [AdminController::class, 'deleteuser'])->name('delete.user');
    Route::post('/admin/updateuser', [AdminController::class, 'updateuser'])->name('update.user');

    Route::get('/admin/settingapp', [AdminController::class, 'settingapp'])->name('admin.settingapp');
    Route::post('/admin/settingapp', [AdminController::class, 'addsettingapp'])->name('admin.addsettingapp');
    Route::delete('/admin/deletesettingapp', [AdminController::class, 'deletesettingapp'])->name('admin.deletesettingapp');
    Route::post('/admin/updatesettingapp', [AdminController::class, 'updateApp'])->name('update.app');
});