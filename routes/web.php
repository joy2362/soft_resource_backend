<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

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
Route::resource('item', ItemController::class,array('except'=>['create','show']));
Route::resource('sub-category', SubCategoryController::class,array('except'=>['create','show']));
Route::resource('setting', SettingController::class,array('except'=>['create','show']));
Route::post('setting/change/logo', [SettingController::class,'change_logo'])->name('setting.logo.change');
Route::get('sub-category/fetch/{category}', [SubCategoryController::class,'fetch_sub_category']);

Route::get('/profile/setting',[AdminController::class,'profile_setting'])->name('profile.setting');

Route::get('/profile/setting/recovery-codes', function () {
    return view('admin.pages.profile_setting.recovery');
});

Route::get('/profile/edit',[AdminController::class, 'profile_edit'])->name('profile.edit');

Route::put('/profile-image', [AdminController::class, 'image_update'])->name('profile-image.update');
