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
    {
    
      /*
        $fichas = 500; 
        
        $resposta = '';  
        
        $options = [];    
        
        foreach ($this->question::whereQuizCampaignId(1)->get() as $question) {
          
          $qtdeOpcoes = $question->options->count();
          
          foreach ($question->options as $option) {
            
            $option =  @json_decode(json_encode($option), true);
            $option['times'] = 0; 
                              
            $dividedAll = $fichas/$qtdeOpcoes;// 100 / 9 = 11.11
            $restDivided = $fichas-$dividedAll;// 100 - 11.11 = 88
            $restDividedMinus = $restDivided/$qtdeOpcoes; // 88/9 = 9.87
            
            $dividedAllWithMinus = $dividedAll+$restDividedMinus;// 11.11 + 9.87 = 20.98 *
            $fichas = $fichas-$dividedAllWithMinus; 
            
            $a = 1;
            while ($a <= $dividedAllWithMinus) {   
                        
              $a++;
              $option['times']++;
            }  
            $options[] = $option;
          }  
        }    
        
        foreach ($options as $key => $value) {
          $resposta .= $value['times'].'<br />';
        }
      
        return $resposta;*/
        
        $quizCampaign = request()->session()->get('quizCampaign');
                
        return view('app.quiz.dashboard',compact('quizCampaign'));
  
    }
}
