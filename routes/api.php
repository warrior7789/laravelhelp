<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\User\SpskillController;
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

Route::get('searchskill/{query}', [SpskillController::class, 'searchskill']);
Route::get('allskill', [SpskillController::class, 'allskill']);
Route::post('searchsp', [SpskillController::class, 'searchsp']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
