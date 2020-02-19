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
Route::get('/home', function () {
    return redirect('/app');
});

Auth::routes();

Route::group(['namespace' => 'App','prefix' => 'app','middleware'=>'auth'],function() {
  
    Route::get('/', 'DashboardController@index');    
    Route::resource('/pessoas', 'PersonController');
    Route::resource('/bairros', 'DistrictController');
    Route::resource('/politicos', 'PoliticController');
    Route::resource('/partido-politicos', 'PoliticalPartyController');
    Route::resource('/campanhas', 'Quiz\QuizCampaignController');
    Route::get('/error',function() {
      return view('app._utils.error');
    });
    
    Route::group(['prefix'=>'campanha','middleware'=>'auth','namespace'=>'Quiz','as'=>'Quiz'], function (){
             
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
          Route::get('/error',function() {
            return view('app.error');
          });      
      });
    });
    
});

