<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ExpertcategoriesController;
use App\Http\Controllers\Api\FavoriteexpertController;
use App\Http\Controllers\Api\StarController;
use App\Http\Controllers\Api\TimeController;

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
Route::group(['middleware' => ['changeLang','auth:sanctum'],'namespace'=>'Api'],function() {
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('show',[PersonController::class,'show']);
    Route::post('update',[PersonController::class,'update']);
    Route::post('updatephoto',[PersonController::class,'updatePhoto']);
    Route::post('addexpertcategorie',[ExpertcategoriesController::class,'create']);
    Route::get('deletecategorie/{id}',[ExpertcategoriesController::class,'destroy']);
    Route::post('updatecategorie/{id}',[ExpertcategoriesController::class,'update']);
    Route::get('showexpertsofcategorie/{id}',[ExpertcategoriesController::class,'show']);
    Route::get('addexperttofavorite/{id}',[FavoriteexpertController::class,'create']);
    Route::get('deleteexpertfromfavorite/{id}',[FavoriteexpertController::class,'destroy']);
    Route::get('isinfavoritelist/{id}',[FavoriteexpertController::class,'show']);
    Route::get('givestar/{id}/{num}',[StarController::class,'create']);
    Route::get('showstars/{id}',[StarController::class,'show']);
    Route::post('search',[ExpertCategoriesController::class,'index']);
    Route::post('availableTimeCreate',[TimeController::class,'availableTimeCreate']);
    Route::post('availableTimeUpdate',[TimeController::class,'availableTimeUpdate']);
    Route::post('availableTimeDelete',[TimeController::class,'availableTimeDelete']);
    Route::post('availableTimeForMe',[TimeController::class,'availableTimeForMe']);
    Route::post('availableTimeForExpert',[TimeController::class,'availableTimeForExpert']);
    Route::post('bookedTimeCreate',[TimeController::class,'bookedTimeCreate']);
    Route::post('bookedTimeShow',[TimeController::class,'bookedTimeShow']);
    Route::post('search1',[ExpertCategoriesController::class,'searchexpertroute1']);
    Route::post('search2',[ExpertCategoriesController::class,'searchexpertroute2']);

});
