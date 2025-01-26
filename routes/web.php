<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('admin:admin')->group(function (){
    Route::controller(AdminController::class)->group(function (){
        Route::get('admin/login', 'LoginForm');
        Route::post('admin/login', 'store')->name('admin.login');
    });
});


Route::middleware([
    'auth:sanctum,admin',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');
});



// Admin All Routes
Route::get('admin/logout',[AdminController::class, 'destroy'])->name('admin.logout');
Route::get('admin/profile',[AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
Route::get('admin/profile/edit',[AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
Route::get('admin/change/password',[AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');


Route::post('admin/profile/store',[AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::post('update/change/password',[AdminProfileController::class, 'AdminUpdateChangePassword'])->name('admin.update.change.password');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
