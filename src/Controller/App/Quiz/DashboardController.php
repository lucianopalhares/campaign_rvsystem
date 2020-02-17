<?php

namespace App\Controller\App\Quiz;

use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    public $campaign;
    public $question;
    public $option;
    public $answer;
    
    public function __construct()
    {
        $this->campaign = \App::make('App\Domain\Quiz\Model\QuizCampaign');
        $this->question = \App::make('App\Domain\Quiz\Model\QuizQuestion');
        $this->option = \App::make('App\Domain\Quiz\Model\QuizOption');
        $this->answer = \App::make('App\Domain\Quiz\Model\QuizAnswer');
    }


    public function index()
    {/*
        $fichas = 100;        
        $qtdeOpcoes = 9;
        
        $opcoes = [
          1 => ['number' => 1 , 'times'=>0 , 'rodadas' => [] ],
          2 => ['number' => 2 , 'times'=>0 , 'rodadas' => [] ],
          3 => ['number' => 3 , 'times'=>0 , 'rodadas' => [] ],
          4 => ['number' => 4 , 'times'=>0 , 'rodadas' => [] ],
          5 => ['number' => 5 , 'times'=>0 , 'rodadas' => [] ],
          6 => ['number' => 6 , 'times'=>0 , 'rodadas' => [] ],
          7 => ['number' => 7 , 'times'=>0 , 'rodadas' => [] ],
          8 => ['number' => 8 , 'times'=>0 , 'rodadas' => [] ],
          9 => ['number' => 9 , 'times'=>0 , 'rodadas' => [] ]
        ];
                        
        $resposta = '';
                
        $rodada = 1;
        while ($rodada <= $qtdeOpcoes) {
          
          
          $dividedAll = $fichas/$qtdeOpcoes;// 100 / 9 = 11.11
          $restDivided = $fichas-$dividedAll;// 100 - 11.11 = 88
          $restDividedMinus = $restDivided/$qtdeOpcoes; // 88/9 = 9.87
          
          $dividedAllWithMinus = $dividedAll+$restDividedMinus;// 11.11 + 9.87 = 20.98
          $fichas = $fichas-$dividedAllWithMinus; 
          
            $a = 1;
            while ($a <= $dividedAllWithMinus) {   
              
              $opcao = Arr::random($opcoes);  
              
              
                           
              
              //break;
              $a++;
            }          
          $resposta .= $dividedAllWithMinus.'<br />';          
        //  break;
          $rodada++;   
        }
        
        foreach ($opcoes as $key => $opcao) {
          $rodadas = '';
          foreach ($opcao['rodadas'] as $rodada) {
            $rodadas .= $rodada.', ';
          }
          $resposta .= $opcao['number'].' : '.$opcao['times'].' (RODADAS) '.$rodadas.'<br />';
        }*/
      
        //return $resposta;
        
        $quizCampaign = request()->session()->get('quizCampaign');
                
        return view('app.quiz.dashboard',compact('quizCampaign'));
  
    }
}
