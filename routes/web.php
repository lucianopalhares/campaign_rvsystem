<?php

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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::group(['namespace' => 'App','prefix' => 'app','middleware'=>'auth'],function() {
    Route::get('/', 'DashboardController@index');
    
    Route::group(['namespace' => 'Quiz','prefix' => 'quiz'],function() {
        Route::resource('/campanhas', 'QuizCampaignController');
        Route::resource('/questoes', 'QuizQuestionController');
        Route::resource('/opcoes', 'QuizOptionController');
        Route::resource('/respostas', 'QuizAnswerController');
    });
    Route::resource('/pessoas', 'Person\PersonController');
    Route::resource('/bairros', 'City\DistrictController');
});