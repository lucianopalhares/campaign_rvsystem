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
///ROTAS API - INICIO
Route::group(['namespace' => 'App','middleware' => 'web'],function() {

    Route::resource('/pessoas', 'PersonController');
    Route::resource('/bairros', 'DistrictController');
    Route::resource('/politicos', 'PoliticController');
    Route::resource('/partido-politicos', 'PoliticalPartyController');
    Route::resource('/campanhas', 'Quiz\QuizCampaignController');
    
    Route::group(['prefix'=>'campanha','namespace'=>'Quiz','as'=>'Quiz'], function (){
             
      Route::group([
            'prefix' => '{quizCampaignSlug}',
            'middleware' => 'quizCampaign'
        ], function () {
            Route::get('dashboard', [
                'as'   => '/',
                'uses' => 'DashboardController@index',
            ]);
            Route::get('dashboard', [
                'as'   => '/',
                'uses' => 'DashboardController@index',
            ]);            
            
          
          Route::get('relatorio','DashboardController@relatorio');
          Route::get('espelho','DashboardController@espelho');
             
          Route::resource('questoes','QuizQuestionController', array("as"=>"questoes","name"=>"questoes"));
          Route::resource('opcoes','QuizOptionController', array("as"=>"opcoes","name"=>"opcoes"));
          Route::resource('respostas','QuizAnswerController', array("as"=>"respostas","name"=>"respostas"));
     
      });
    });
    
});
///ROTAS API - FIM

Route::get('/states', 'App\StateController@index');
Route::get('/cities/{state}', 'App\StateController@cities');
Route::get('/cities', 'App\CityController@index');
Route::get('/districts', 'App\DistrictController@index');
Route::get('/districts/{city}', 'App\CityController@districts');
Route::get('/questions/{campanha}', 'App\Quiz\QuizCampaignController@questions');
Route::get('/options/{questo}', 'App\Quiz\QuizQuestionController@options');