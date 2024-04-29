<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'admin.login')->name('admin.login');
Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');

Route::middleware(['admin_auth'])->group(function () {
    Route::get('home', [AdminController::class, 'home'])->name('admin.home');
});
