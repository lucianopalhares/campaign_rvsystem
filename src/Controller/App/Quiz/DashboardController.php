<?php

namespace App\Controller\App\Quiz;

use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Support\Arr;
use PDF;

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
        $quizCampaign = request()->session()->get('quizCampaign');
                
        return view('app.quiz.dashboard2',compact('quizCampaign'));  
    }
    public function downloadPDF() {
      
      $quizCampaign = request()->session()->get('quizCampaign');
      
      return view('app.quiz.dashboard2',compact('quizCampaign'));  
              
      //$pdf = PDF::loadView('app.quiz.dashboard2',compact('quizCampaign'));        
      //return $pdf->download($quizCampaign->slug.'.pdf');
        
    }
}
