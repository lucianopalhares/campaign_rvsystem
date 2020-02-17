<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizQuestion;
use App\Domain\Quiz\Model\QuizCampaign;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class QuizQuestionController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $option;
    protected $campaign;
    protected $quizCampaignSlug;
    protected $state;
    protected $politic;
    protected $city;
    protected $district;
    
    public function __construct(){
      $this->name = 'Questão';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.question.';
      $this->model = App::make("App\Domain\Quiz\Model\QuizQuestion");
      $this->option = App::make("App\Domain\Quiz\Model\QuizOption");
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");      
      $this->political_party = App::make("App\Domain\Political\Model\PoliticalParty");
      $this->politic = App::make("App\Domain\Political\Model\Politic");
      $this->state = App::make("App\Domain\City\Model\State");
      $this->city = App::make("App\Domain\City\Model\City");
      $this->district = App::make("App\Domain\City\Model\District");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($quizCampaignSlug)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */    
                
        $items = $this->model::whereQuizCampaignId($quizCampaign->id)->get();
        return view($this->pathView.'index',compact('items','quizCampaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($quizCampaignSlug)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */

        $political_parties = $this->political_party::all();
        $politics = $this->politic::with('political_office')->get();   
        $states = $this->state::all();
        $cities = $this->city::with('state')->get();
        $districts = $this->district::with('city','city.state')->get();
                                
        return view($this->pathView.'form',compact('quizCampaign','political_parties','politics','states','cities','districts'));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quizCampaignSlug)
    {        
        $rules = [
            'quiz_campaign_id' =>  'required',
            'description' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        if(!$request->quiz_questionable_id||!$request->quiz_questionable_type||!$request->quiz_questionable_name){
            $request->quiz_questionable_id = null;
            $request->quiz_questionable_type = null;
            $request->quiz_questionable_name = null;          
        }
                
        try {
            $model = new $this->model;
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->options_required = $request->options_required;
            $model->quiz_questionable_id = $request->quiz_questionable_id;
            $model->quiz_questionable_type = $request->quiz_questionable_type;
            $model->quiz_questionable_name = $request->quiz_questionable_name;
            
            $save = $model->save();
            
            $response = $this->name;
            
            $response .= ' Cadastrado(a) com Sucesso!';
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }            
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function show(QuizQuestion $questo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($quizCampaignSlug, QuizQuestion $questo)
    {
        try {
          /* inserir em todos metodos - inicio */
          $quizCampaign = request()->session()->get('quizCampaign');
          $this->link .= $quizCampaign->slug.'/questoes';
          /* inserir em todos metodos - fim */
          
          $item = $questo;

          $political_parties = $this->political_party::all();
          $politics = $this->politic::with('political_office')->get();   
          $states = $this->state::all();
          $cities = $this->city::with('state')->get();
          $districts = $this->district::with('city','city.state')->get();
                                  
          return view($this->pathView.'form',compact('item','quizCampaign','political_parties','politics','states','cities','districts'));
      
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quizCampaignSlug, QuizQuestion $questo)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'description' =>  'required'
        ]; 

        $this->validate($request, $rules);

        if(!$request->quiz_questionable_id||!$request->quiz_questionable_type||!$request->quiz_questionable_name){
            $request->quiz_questionable_id = null;
            $request->quiz_questionable_type = null;
            $request->quiz_questionable_name = null;          
        }
              
        try {
            $model = $questo;
            
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->options_required = $request->options_required;
            $model->quiz_questionable_id = $request->quiz_questionable_id;
            $model->quiz_questionable_type = $request->quiz_questionable_type;
            $model->quiz_questionable_name = $request->quiz_questionable_name;
            
            $save = $model->save();
            
            $response = $this->name;
            
            $response .= ' Atualizado(a) com Sucesso!';
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }            
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizCampaignSlug, QuizQuestion $questo)
    {
        try {
                      
            $questo->delete();
            
            $response = $this->name;
            
            $response .= ' Deletado(a) com Sucesso!';
                                                
            if (request()->wantsJson()) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }    
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }  
    }
    public function options(QuizQuestion $questo){
      
      $data = [];
      $data['quiz_question'] = $questo;
      $data['data'] = [];
      foreach ($questo->options as $option) {
        $description = '';
        if($option->description){
          $description = $option->description;
        }
        if($option->quiz_optionable_id){
          $description .= ' '.$option->quiz_optionable->nable();
        }
        $insert['description'] = $description;
        $insert['id'] = $option->id;
        $data['data'][] = $insert;
      }    
      return response()->json($data);
    }
}


