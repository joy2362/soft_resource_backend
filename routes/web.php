<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\RoleControlelr;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TrashController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Artisan;
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

//dashboard
Route::get('/',  [AdminController::class, 'dashboard'])->name('home');

//resource crud
Route::resource('category', CategoryController::class,array('except'=>['create','show']));
Route::resource('item', ItemController::class,array('except'=>['show']));
Route::resource('sub-category', SubCategoryController::class,array('except'=>['create','show']));
Route::resource('role', RoleControlelr::class,array('except'=>['show']));
Route::resource('user', UserController::class,array('except'=>['create','show']));
Route::resource('setting', SettingController::class,array('except'=>['create','show']));


//trash
Route::get('recycle-bin', [TrashController::class,'index'])->name('recycle-bin.index');
//recover
Route::get('category/{category}/recover', [TrashController::class,'categoryRecover'])->name('category.recover');
Route::get('subcategory/{id}/recover', [TrashController::class,'subCategoryRecover'])->name('subCategory.recover');
Route::get('item/{item}/recover', [TrashController::class,'itemRecover'])->name('item.recover');

//permanently delete
Route::get('category/{category}/delete/permanently', [TrashController::class,'categoryForceDelete'])->name('category.delete.completely');
Route::get('subcategory/{id}/delete/permanently', [TrashController::class,'subCategoryForceDelete'])->name('subCategory.delete.completely');
Route::get('item/{item}/delete/permanently', [TrashController::class,'itemForceDelete'])->name('item.delete.completely');

//application setting
Route::post('setting/change/logo', [SettingController::class,'change_logo'])->name('setting.logo.change');
Route::get('sub-category/fetch/{category}', [SubCategoryController::class,'fetch_sub_category']);

//admin profile
Route::get('/profile/setting',[AdminController::class,'profile_setting'])->name('profile.setting');
Route::get('/profile/setting/recovery-codes', [AdminController::class, 'recoveryCodeShow']);
Route::get('/profile/edit',[AdminController::class, 'profile_edit'])->name('profile.edit');
Route::put('/profile-image', [AdminController::class, 'image_update'])->name('profile-image.update');
//two-step verification recovery
Route::get('/two-factor-recover',  [AdminController::class, 'two_factor_recover']);
Route::get('/storage/link',  function (){
    Artisan::call('storage:link');
});
