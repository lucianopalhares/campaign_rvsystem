<?php

namespace App\Controller\App;

use Illuminate\Http\Request;
use App\Controller\Controller;

class DashboardController extends Controller
{
    public $campaign;
    public $person;
    public $politic;
    public $political_party;
    
    public function __construct()
    {
        $this->campaign = \App::make('App\Domain\Quiz\Model\QuizCampaign');
        $this->person = \App::make('App\Domain\Person\Model\Person');
        $this->politic = \App::make('App\Domain\Political\Model\Politic');
        $this->political_party = \App::make('App\Domain\Political\Model\PoliticalParty');
    }


    public function index()
    {
        $campaigns = $this->campaign::count();        
        $people = $this->person::count();
        $politics = $this->politic::count();
        $political_parties = $this->political_party::count();
        
        
        return view('app.dashboard',compact('campaigns','people','politics','political_parties'));
  
    }
}
