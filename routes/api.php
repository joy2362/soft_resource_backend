<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\itemController;
use App\Http\Controllers\Api\sub_categoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/categories',CategoryController::class)->only('index','show');
Route::resource('/sub-categories',sub_categoryController::class)->only('index','show');
Route::resource('/items',itemController::class)->only('index','show');

Route::get('/is-requested/items',[itemController::class,'requestedItem']);
Route::get('/categories/{id}/items',[itemController::class,'itemByCategory']);
Route::get('/sub-categories/{id}/items',[itemController::class,'itemBySubCategory']);
Route::get('/slider/items',[itemController::class,'sliderItem']);
Route::get('/settings',[ApiController::class,'settings']);
Route::post('/items/search',[ApiController::class,'searchItem']);




