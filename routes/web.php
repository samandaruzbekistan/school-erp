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
    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');


    Route::get('classes', [AdminController::class, 'classes'])->name('classes');
    Route::post('classes-new', [AdminController::class, 'classes_new'])->name('classes.new');
    Route::get('classes-users/{id?}', [AdminController::class, 'class_users'])->name('classes.users');

//    Users control
    Route::get('user/{id}', [AdminController::class, 'user'])->name('user');
    Route::get('applicants', [AdminController::class, 'applicants'])->name('applicants');
    Route::post('new-student', [AdminController::class, 'add_user'])->name('user.add');
    Route::get('delete-student/{id}', [AdminController::class, 'delete_user'])->name('delete.applicant');

//  Region control
    Route::get('districts/{region_id?}', [AdminController::class,'districts'])->name('cashier.district.regionID');
    Route::get('quarters/{district_id?}', [AdminController::class,'quarters'])->name('cashier.quarter.districtID');
});
