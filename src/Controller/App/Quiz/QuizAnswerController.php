<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizAnswer;
use App\Domain\Quiz\Model\QuizCampaign;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class QuizAnswerController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $campaign;
    protected $question;
    protected $option;
    protected $quizCampaignSlug;
    protected $state;
    protected $politic;
    protected $city;
    protected $district;
    
    public function __construct(QuizAnswer $model){
      $this->name = 'Resposta';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.answer.';
      $this->model = App::make("App\Domain\Quiz\Model\QuizAnswer");
      $this->option = App::make("App\Domain\Quiz\Model\QuizOption");
      $this->question = App::make("App\Domain\Quiz\Model\QuizQuestion");
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
    public function index($quizCampaignSlug, Request $request)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/opcoes';
        /* inserir em todos metodos - fim */    
        
        $items = $this->model::whereQuizCampaignId($quizCampaign->id)->get();
        
        if($request->has('quiz_question_id')){
          $items = $this->model::whereQuizQuestionId($request->quiz_question_id)->whereQuizCampaignId($quizCampaign->id)->get();
        }   
        if($request->has('quiz_option_id')){
          $items = $this->model::whereQuizOptionId($request->quiz_option_id)->whereQuizCampaignId($quizCampaign->id)->get();
        }  

        if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items','quizCampaign'));
        }                        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */
           
        $states = $this->state::all();
        $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->get();
                                
        return view($this->pathView.'form',compact('quizCampaign','states','questions'));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required',
            //'quiz_option_id' =>  'required',
            //'description' =>  'required',
            'name' =>  'required',
            //'address' =>  'required',
            //'district' =>  'required',
            //'zip_code' =>  'required',
            //'state_id' =>  'required',
            //'city_id' =>  'required'
        ]; 

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }     
        }       
        

        
        try {          
                
            if($this->question::findOrFail($request->quiz_question_id)->options_required){
              if(!$request->quiz_option_id){            
                if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
                  return response()->json(['status'=>false,'msg'=>'Escolha uma Opção como Resposta ou aguarde o cadastro de novas opções (questão multipla escolha)']);
                }else{
                
                  return back()->withInput($request->toArray())->withErrors('Escolha uma Opção como Resposta ou aguarde o cadastro de novas opções (questão multipla escolha)');
                }
              }
            }else{
              if(strlen($request->description)==0){
                if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
                  return response()->json(['status'=>false,'msg'=>'Responda a Questão na DESCRIÇÃO, não é multipla escolha (não tem opções cadastradas para esta questão)']);
                }else{
                
                  return back()->withInput($request->toArray())->withErrors('Responda a Questão na DESCRIÇÃO, não é multipla escolha (não tem opções cadastradas para esta questão)');
                }
              }
            }
        
            $model = new $this->model;
            
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->quiz_question_id = $request->quiz_question_id;
            $model->answered_times = $request->answered_times;
            $model->description = $request->description; 
            $model->quiz_option_id = $request->quiz_option_id;                            
            $model->name = $request->name;  
            $model->sex = $request->sex;
            $model->years_old = $request->years_old;
            $model->salary = $request->salary;
            $model->education_level = $request->education_level; 
            $model->state_id = $request->state_id; 
            $model->city_id = $request->city_id; 
            $model->district_id = $request->district_id; 
            $model->address = $request->address;               
            $model->zip_code = $request->zip_code;  
            $model->latitude = $request->latitude;  
            $model->longitude = $request->longitude;  
            
            $save = $model->save();
            
            $response = $this->name;
            
            $response .= ' Cadastrado(a) com Sucesso!';
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
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
            
            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function show($quizCampaignSlug, QuizAnswer $resposta)
    {
        try {
                      
            $item = $resposta;
            
            /* inserir em todos metodos - inicio */
            $quizCampaign = request()->session()->get('quizCampaign');
            $this->link .= $quizCampaign->slug.'/questoes';
            /* inserir em todos metodos - fim */
               
            $states = $this->state::all();
            $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->get();
            
            $show = true;
                                    
            return view($this->pathView.'form',compact('item','quizCampaign','states','show','questions'));  
            
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($quizCampaignSlug, QuizAnswer $resposta)
    {
        try {
                      
            $item = $resposta;
            
            /* inserir em todos metodos - inicio */
            $quizCampaign = request()->session()->get('quizCampaign');
            $this->link .= $quizCampaign->slug.'/questoes';
            /* inserir em todos metodos - fim */
               
            $states = $this->state::all();
            $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->get();
                                    
            return view($this->pathView.'form',compact('item','quizCampaign','states','questions')); 
            
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
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quizCampaignSlug, QuizAnswer $resposta)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required',
            //'quiz_option_id' =>  'required',
            //'description' =>  'required',
            'name' =>  'required',
        ]; 

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }     
        }   
        

                
        try {
          
            if($this->question::findOrFail($request->quiz_question_id)->options_required){
              if(!$request->quiz_option_id){            
                if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
                  return response()->json(['status'=>false,'msg'=>'Escolha uma Opção como Resposta ou aguarde o cadastro de novas opções (questão multipla escolha)']);
                }else{
                
                  return back()->withInput($request->toArray())->withErrors('Escolha uma Opção como Resposta ou aguarde o cadastro de novas opções (questão multipla escolha)');
                }
              }
            }else{
              if(strlen($request->description)==0){
                if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
                  return response()->json(['status'=>false,'msg'=>'Responda a Questão na DESCRIÇÃO, não é multipla escolha (não tem opções cadastradas para esta questão)']);
                }else{
                
                  return back()->withInput($request->toArray())->withErrors('Responda a Questão na DESCRIÇÃO, não é multipla escolha (não tem opções cadastradas para esta questão)');
                }
              }
            }
        
            $model = $resposta;
            
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->quiz_question_id = $request->quiz_question_id;
            $model->answered_times = $request->answered_times;
            $model->description = $request->description; 
            $model->quiz_option_id = $request->quiz_option_id;                            
            $model->name = $request->name;  
            $model->sex = $request->sex;
            $model->years_old = $request->years_old;
            $model->salary = $request->salary;
            $model->education_level = $request->education_level; 
            $model->state_id = $request->state_id; 
            $model->city_id = $request->city_id; 
            $model->district_id = $request->district_id; 
            $model->address = $request->address;               
            $model->zip_code = $request->zip_code;     
            $model->latitude = $request->latitude;  
            $model->longitude = $request->longitude;  
                        
            $save = $model->save();
            
            $response = $this->name;
            
            $response .= ' Atualizado(a) com Sucesso!';
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
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
            
            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e); 
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizCampaignSlug, QuizAnswer $resposta)
    {
        try {
                      
            $resposta->delete();
            
            $response = $this->name;
            
            $response .= ' Deletado(a) com Sucesso!';
                                                
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
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
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }  
    }
}


