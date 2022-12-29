<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ExpertcategoriesController;
use App\Http\Controllers\Api\FavoriteexpertController;
use App\Http\Controllers\Api\StarController;

use App\Models\Expertcategorie;

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

Route::post('register', [AuthController::class, 'createUser']);
Route::post('login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('show',[PersonController::class,'show'])->middleware('auth:sanctum');
Route::post('update',[PersonController::class,'update'])->middleware('auth:sanctum');
Route::post('updatephoto',[PersonController::class,'updatePhoto'])->middleware('auth:sanctum');
Route::post('addcategorie',[CategoriesController::class,'create']);
Route::post('addexpertcategorie',[ExpertcategoriesController::class,'create'])->middleware('auth:sanctum');
Route::get('deletecategorie/{id}',[ExpertcategoriesController::class,'destroy']);
Route::post('updatecategorie/{id}',[ExpertcategoriesController::class,'update']);
Route::get('showexpertsofcategorie/{id}',[ExpertcategoriesController::class,'show']);
Route::get('addexperttofavorite/{id}',[FavoriteexpertController::class,'create'])->middleware('auth:sanctum');
Route::get('deleteexpertfromfavorite/{id}',[FavoriteexpertController::class,'destroy'])->middleware('auth:sanctum');
Route::get('isinfavoritelist/{id}',[FavoriteexpertController::class,'show'])->middleware('auth:sanctum');
Route::get('givestar/{id}/{num}',[StarController::class,'create'])->middleware('auth:sanctum');
Route::get('showstars/{id}',[StarController::class,'show']);
Route::post('search',[ExpertCategoriesController::class,'index']);