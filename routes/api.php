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
<<<<<<< HEAD

Route::post('/login', 'Auth\LoginApiController@login');


///ROTAS API - INICIO


Route::group(['namespace' => 'App'],function() {
=======
///ROTAS API - INICIO
Route::group(['namespace' => 'App','middleware' => 'web'],function() {
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af

    Route::resource('/pessoas', 'PersonController');
    Route::resource('/bairros', 'DistrictController');
    Route::resource('/politicos', 'PoliticController');
    Route::resource('/partido-politicos', 'PoliticalPartyController');
    Route::resource('/campanhas', 'Quiz\QuizCampaignController');
<<<<<<< HEAD

    Route::group(['prefix'=>'campanha','namespace'=>'Quiz','as'=>'Quiz'], function (){

=======
    
    Route::group(['prefix'=>'campanha','namespace'=>'Quiz','as'=>'Quiz'], function (){
             
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
      Route::group([
            'prefix' => '{quizCampaignSlug}',
            'middleware' => 'quizCampaign'
        ], function () {
            Route::get('dashboard', [
                'as'   => '/',
                'uses' => 'DashboardController@index',
            ]);
<<<<<<< HEAD

          Route::get('relatorio','DashboardController@relatorio');
          Route::get('espelho','DashboardController@espelho');

          Route::resource('questoes','QuizQuestionController', array("as"=>"questoes","name"=>"questoes"));
          Route::resource('opcoes','QuizOptionController', array("as"=>"opcoes","name"=>"opcoes"));
          Route::resource('respostas','QuizAnswerController', array("as"=>"respostas","name"=>"respostas"));
          Route::resource('bairros','DistrictController', array("as"=>"bairros","name"=>"bairros"));

      });
    });

=======
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
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
});
///ROTAS API - FIM

Route::get('/states', 'App\StateController@index');
Route::get('/cities/{state}', 'App\StateController@cities');
Route::get('/cities', 'App\CityController@index');
Route::get('/districts', 'App\DistrictController@index');
Route::get('/districts/{city}', 'App\CityController@districts');
Route::get('/questions/{campanha}', 'App\Quiz\QuizCampaignController@questions');
<<<<<<< HEAD
Route::get('/options/{questo}', 'App\Quiz\QuizQuestionController@options');

Route::resource('telefones','PhoneNumberController', array("as"=>"telefones","name"=>"telefones"));
=======
Route::get('/options/{questo}', 'App\Quiz\QuizQuestionController@options');
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
