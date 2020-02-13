<?php

namespace App\Controller\App;

use Illuminate\Http\Request;
use App\Controller\Controller;

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
        $campaigns = $this->campaign::count();
        $questions = $this->question::count();
        $options = $this->option::count();
        $answers = $this->answer::count();
        
        return view('app.dashboard',compact('campaigns','questions','options','answers'));
  
    }
}
