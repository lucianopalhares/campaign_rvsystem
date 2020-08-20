<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizOption;
use App\Domain\Quiz\Model\QuizCampaign;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class QuizOptionController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $campaign;
    protected $question;
    protected $quizCampaignSlug;
    protected $state;
    protected $politic;
    protected $city;
    protected $district;
    protected $person;
<<<<<<< HEAD

=======
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    public function __construct(){
      $this->name = 'Opção';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.option.';
      $this->model = App::make("App\Domain\Quiz\Model\QuizOption");
      $this->question = App::make("App\Domain\Quiz\Model\QuizQuestion");
<<<<<<< HEAD
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");
=======
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");      
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
      $this->political_party = App::make("App\Domain\Political\Model\PoliticalParty");
      $this->politic = App::make("App\Domain\Political\Model\Politic");
      $this->state = App::make("App\Domain\City\Model\State");
      $this->city = App::make("App\Domain\City\Model\City");
      $this->district = App::make("App\Domain\City\Model\District");
      $this->person = App::make("App\Domain\Person\Model\Person");
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
<<<<<<< HEAD
        /* inserir em todos metodos - fim */

        $items = $this->model::whereQuizCampaignId($quizCampaign->id)->get();

        if($request->has('quiz_question_id')){
          $items = $this->model::whereQuizQuestionId($request->quiz_question_id)->whereQuizCampaignId($quizCampaign->id)->get();
        }

        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items','quizCampaign'));
        }

=======
        /* inserir em todos metodos - fim */    
        
        $items = $this->model::whereQuizCampaignId($quizCampaign->id)->get();
        
        if($request->has('quiz_question_id')){
          $items = $this->model::whereQuizQuestionId($request->quiz_question_id)->whereQuizCampaignId($quizCampaign->id)->get();
        }               

        if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items','quizCampaign'));
        }           
        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
<<<<<<< HEAD
    {
=======
    {      
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */
<<<<<<< HEAD

=======
        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->whereOptionsRequired('1')->get();

        $people = $this->person::all();
        $political_parties = $this->political_party::all();
<<<<<<< HEAD
        $politics = $this->politic::with('political_office')->get();
        $states = $this->state::all();
        $cities = $this->city::with('state')->get();
        $districts = $this->district::with('city','city.state')->get();

        return view($this->pathView.'form',compact('quizCampaign','questions','political_parties','politics','states','cities','districts','people'));

=======
        $politics = $this->politic::with('political_office')->get();   
        $states = $this->state::all();
        $cities = $this->city::with('state')->get();
        $districts = $this->district::with('city','city.state')->get();
                                
        return view($this->pathView.'form',compact('quizCampaign','questions','political_parties','politics','states','cities','districts','people'));
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quizCampaignSlug)
<<<<<<< HEAD
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required'
        ];
=======
    {        
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required'
        ]; 
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
<<<<<<< HEAD
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
=======
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
<<<<<<< HEAD
            }
        }

        if(!$request->quiz_optionable_id||!$request->quiz_optionable_type||!$request->quiz_optionable_name){
            $request->quiz_optionable_id = null;
            $request->quiz_optionable_type = null;
            $request->quiz_optionable_name = null;
        }

        if(!$request->quiz_optionable_id&&strlen($request->description)==0){
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
=======
            }     
        } 
        
        if(!$request->quiz_optionable_id||!$request->quiz_optionable_type||!$request->quiz_optionable_name){
            $request->quiz_optionable_id = null;
            $request->quiz_optionable_type = null;
            $request->quiz_optionable_name = null;          
        }

        if(!$request->quiz_optionable_id&&strlen($request->description)==0){
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
              return response()->json(['status'=>false,'msg'=>'Preencha a Descrição 1 ou a Descrição 2']);
            }else{
              return redirect()->back()
                        ->withErrors('Preencha a Descrição 1 ou a Descrição 2')
                        ->withInput();
<<<<<<< HEAD
            }
        }

=======
            } 
        }
                        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        try {
            $model = new $this->model;
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->quiz_optionable_id = $request->quiz_optionable_id;
            $model->quiz_optionable_type = $request->quiz_optionable_type;
            $model->quiz_optionable_name = $request->quiz_optionable_name;
            $model->quiz_question_id = $request->quiz_question_id;
<<<<<<< HEAD

            $save = $model->save();

            $response = $this->name;

            $response .= ' Cadastrado(a) com Sucesso!';

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
            
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
            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
<<<<<<< HEAD
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

        }
=======
            }    
            
            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);           
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
        } 
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuizOption  $model
     * @return \Illuminate\Http\Response
     */
    public function show(QuizOption $opco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizOption  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($quizCampaignSlug, QuizOption $opco)
    {
        try {
          /* inserir em todos metodos - inicio */
          $quizCampaign = request()->session()->get('quizCampaign');
          $this->link .= $quizCampaign->slug.'/questoes';
          /* inserir em todos metodos - fim */
<<<<<<< HEAD

=======
          
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
          $item = $opco;

          $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->whereOptionsRequired('1')->get();

          $people = $this->person::all();
          $political_parties = $this->political_party::all();
<<<<<<< HEAD
          $politics = $this->politic::with('political_office')->get();
          $states = $this->state::all();
          $cities = $this->city::with('state')->get();
          $districts = $this->district::with('city','city.state')->get();

          return view($this->pathView.'form',compact('item','quizCampaign','questions','political_parties','politics','states','cities','districts','people'));


        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
          $politics = $this->politic::with('political_office')->get();   
          $states = $this->state::all();
          $cities = $this->city::with('state')->get();
          $districts = $this->district::with('city','city.state')->get();
                                  
          return view($this->pathView.'form',compact('item','quizCampaign','questions','political_parties','politics','states','cities','districts','people'));
      
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
<<<<<<< HEAD
            }

=======
            }              
            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
<<<<<<< HEAD
            }

        }
=======
            }  
          
        }  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuizOption  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quizCampaignSlug, QuizOption $opco)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id'=>  'required'
<<<<<<< HEAD
        ];
=======
        ]; 
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
<<<<<<< HEAD
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
=======
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
<<<<<<< HEAD
            }
        }

        if(!$request->quiz_optionable_id||!$request->quiz_optionable_type||!$request->quiz_optionable_name){
            $request->quiz_optionable_id = null;
            $request->quiz_optionable_type = null;
            $request->quiz_optionable_name = null;
        }

        if(!$request->quiz_optionable_id&&strlen($request->description)==0){
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
=======
            }     
        } 
        
        if(!$request->quiz_optionable_id||!$request->quiz_optionable_type||!$request->quiz_optionable_name){
            $request->quiz_optionable_id = null;
            $request->quiz_optionable_type = null;
            $request->quiz_optionable_name = null;          
        }

        if(!$request->quiz_optionable_id&&strlen($request->description)==0){
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
              return response()->json(['status'=>false,'msg'=>'Preencha a Descrição 1 ou a Descrição 2']);
            }else{
              return redirect()->back()
                        ->withErrors('Preencha a Descrição 1 ou a Descrição 2')
                        ->withInput();
<<<<<<< HEAD
            }
        }

        try {
            $model = $opco;

=======
            } 
        }
              
        try {
            $model = $opco;
            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->quiz_optionable_id = $request->quiz_optionable_id;
            $model->quiz_optionable_type = $request->quiz_optionable_type;
            $model->quiz_optionable_name = $request->quiz_optionable_name;
            $model->quiz_question_id = $request->quiz_question_id;
<<<<<<< HEAD

            $save = $model->save();

            $response = $this->name;

            $response .= ' Atualizado(a) com Sucesso!';

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
            
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
            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
<<<<<<< HEAD
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

=======
            }         
            
            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);      
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuizOption  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizCampaignSlug, QuizOption $opco)
    {
        try {
<<<<<<< HEAD

            $opco->delete();

            $response = $this->name;

            $response .= ' Deletado(a) com Sucesso!';

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
                      
            $opco->delete();
            
            $response = $this->name;
            
            $response .= ' Deletado(a) com Sucesso!';
                                                
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('success', $response);
            }    
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
<<<<<<< HEAD
            }

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }

        }
    }
}
=======
            }              
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }  
    }
}


>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
