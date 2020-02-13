<?php

use Illuminate\Http\Request;

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
Route::get('/cities/{state}', 'App\City\StateController@cities');
Route::get('/questions/{campanha}', 'App\Quiz\QuizCampaignController@questions');
Route::get('/options/{questo}', 'App\Quiz\QuizQuestionController@options');
