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
<<<<<<< HEAD

    Route::get('/', 'DashboardController@index');
=======
  
    Route::get('/', 'DashboardController@index');    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    Route::resource('/pessoas', 'PersonController');
    Route::resource('/bairros', 'DistrictController');
    Route::resource('/politicos', 'PoliticController');
    Route::resource('/partido-politicos', 'PoliticalPartyController');
    Route::resource('/campanhas', 'Quiz\QuizCampaignController');
    Route::get('/error',function() {
      return view('app._utils.error');
    });
<<<<<<< HEAD

    Route::group(['prefix'=>'campanha','middleware'=>'auth','namespace'=>'Quiz','as'=>'Quiz'], function (){

=======
    
    Route::group(['prefix'=>'campanha','middleware'=>'auth','namespace'=>'Quiz','as'=>'Quiz'], function (){
             
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
          Route::get('responder-perguntas','QuizAnswerController@responderPerguntas');
          Route::post('responder-pergunta','QuizAnswerController@responderPergunta');

          Route::get('grafico','ChartController@index');

          Route::resource('bairros','DistrictController', array("as"=>"bairros","name"=>"bairros"));
          Route::get('/error',function() {
            return view('app.error');
          });
      });
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
          Route::get('/error',function() {
            return view('app.error');
          });      
      });
    });
    
});

>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
