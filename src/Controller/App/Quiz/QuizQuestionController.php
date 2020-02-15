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
    protected $campaign;
    protected $quizCampaignSlug;
    protected $state;
    protected $politic;
    
    public function __construct(QuizQuestion $model){
      $this->name = 'Questão';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.question.';
      $this->model = $model;
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");
      $this->state = App::make("App\Domain\City\Model\State");
      $this->politic = App::make("App\Domain\Political\Model\Politic");
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
        
        $state = $this->state::all();
        $politic = $this->politic::all();
        
        $merged = $state->merge($politic);
        
        
        dd($merged);
        
        return $merged[1];
                
        $items = $this->model::paginate(10);
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
                
        return view($this->pathView.'form',compact('quizCampaign'));
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
            'description' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = new $this->model;
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->multiple_choice = $request->multiple_choice;
            
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
    public function edit(QuizQuestion $questo)
    {
        try {
            /* inserir em todos metodos - inicio */
            $quizCampaign = request()->session()->get('quizCampaign');
            $this->link .= $quizCampaign->slug.'/questoes';
            /* inserir em todos metodos - fim */      
                            
            $item = $questo;
                                    
            return view($this->pathView.'form',compact('item','quizCampaign'));  
            
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
    public function update(Request $request, QuizQuestion $questo)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'description' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = $questo;
            
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->multiple_choice = $request->multiple_choice;
            
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
    public function destroy(QuizQuestion $questo)
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
      return response()->json($questo->options);
    }
}


