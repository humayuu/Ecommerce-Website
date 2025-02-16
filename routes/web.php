<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\SubCategoryController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('admin:admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
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
Route::get('admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
Route::get('admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
Route::get('admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
Route::get('admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');


Route::post('admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::post('admin/update/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.update.change.password');


// Admin Brand All Routes Start Here
Route::prefix('brand')->group(function () {

    Route::controller(BrandController::class)->group(function () {
        Route::get('/view', 'BrandView')->name('all.brand');
        Route::get('/edit/{id}', 'BrandEdit')->name('brand.edit');
        Route::get('/delete/{id}', 'BrandDelete')->name('brand.delete');


        Route::post('/store', 'BrandStore')->name('brand.store');
        Route::post('/update', 'BrandUpdate')->name('brand.update');
    });
});

// Admin Category All Routes Start Here
Route::prefix('category')->group(function () {

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/view', 'CategoryView')->name('all.category');
        Route::get('/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::get('/delete/{id}', 'CategoryDelete')->name('delete.edit');


        Route::post('/store', 'CategoryStore')->name('category.store');
        Route::post('/update', 'CategoryUpdate')->name('category.update');
    });
});

// Admin Sub Category All Routes Start Here
Route::prefix('category')->group(function () {

    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/sub/view', 'SubCategoryView')->name('all.subcategory');
        Route::get('/sub/edit/{id}', 'SubCategoryEdit')->name('subcategory.edit');
        Route::get('/sub/delete/{id}', 'SubCategoryDelete')->name('subcategory.delete');


        Route::post('/sub/store', 'SubCategoryStore')->name('subcategory.store');
        Route::post('/sub/update', 'SubCategoryUpdate')->name('subcategory.update');
    });


});






// User All Routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('dashboard', compact('user'));
    })->name('dashboard');
});

Route::get('/', [IndexController::class, 'index']);
Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');
Route::get('/user/profile/change/password', [IndexController::class, 'UserChangePassword'])->name('user.change.password');


Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');
Route::post('user/update/change/password', [IndexController::class, 'UserPasswordUpdate'])->name('user.update.change.password');
