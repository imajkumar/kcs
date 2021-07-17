<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CEOController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('getProfile', [AuthController::class, 'getProfile']);
Route::post('updateProfile', [AuthController::class, 'updateProfile']);
Route::get('getCategory', [AuthController::class, 'getCategory']); //OK
Route::get('getSubCategoryA', [AuthController::class, 'getSubCategory']); //NO
Route::get('getProgressA', [AuthController::class, 'getProgress']); //NO

Route::post('setCategorywithEmpID', [AuthController::class, 'setCategorywithEmpID']);
Route::post('setSubCategorywithEmpIDwithSubCatIDCouserID', [AuthController::class, 'setSubCategorywithEmpIDwithSubCatIDCouserID']);


Route::post('getProgressByEmpID', [AuthController::class, 'getProgressByEmpID']);

Route::post('getCategoryByEmpID', [AuthController::class, 'getCategoryByEmpID']);
Route::post('getSubCategoryByCateID', [AuthController::class, 'getSubCategoryByCateID']);
Route::post('getSubCategoryByEmpID', [AuthController::class, 'getSubCategoryByEmpID']);
Route::post('getCompletedCouserByEmpID', [AuthController::class, 'getCompletedCouserByEmpID']);

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. IF ... error persists, contact codexage@gmail.com'], 404);
});