<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  [AdminController::class, 'dashboard'])->name('home');

Route::get('/two-factor-recover',  [AdminController::class, 'two_factor_recover']);
Route::resource('category', CategoryController::class,array('except'=>['create','show']));
Route::resource('/sub-category', SubCategoryController::class,array('except'=>['create','show']));

Route::get('/profile/setting', function () {
    return view('admin.pages.profile_setting.index');
})->middleware('auth:web')->name('profile.setting');

Route::get('/profile/setting/recovery-codes', function () {
    return view('admin.pages.profile_setting.recovery');
})->middleware('auth:web');

Route::get('/profile/edit', function () {
    return view('admin.pages.profile_setting.profile');
})->middleware('auth:web')->name('profile.edit');

Route::put('/profile-image', [AdminController::class, 'image_update'])
->middleware(['auth:web'])
->name('profile-image.update');
