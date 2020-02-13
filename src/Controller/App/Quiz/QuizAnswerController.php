<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizAnswer;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class QuizAnswerController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $campaign;
    protected $state;
    
    public function __construct(QuizAnswer $model){
      $this->name = 'Resposta';
      $this->link = '/app/quiz/respostas';
      $this->pathView = 'app.answer.';
      $this->model = $model;
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");
      $this->state = App::make("App\Domain\City\Model\State");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::paginate(10);
        return view($this->pathView.'index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campaigns = $this->campaign::all();
        
        if(!$campaigns->count()) return redirect('app/quiz/campanhas/create')->withErrors('Primeiro Cadastre uma Campanha');
        
        $states = $this->state::all();
        return view($this->pathView.'form',compact('campaigns','states'));
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
            'quiz_option_id' =>  'required',
            'description' =>  'required',
            'name' =>  'required',
            'address' =>  'required',
            'district' =>  'required',
            'zip_code' =>  'required',
            'state_id' =>  'required',
            'city_id' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = new $this->model;
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->quiz_question_id = $request->quiz_question_id;
            $model->quiz_option_id = $request->quiz_option_id;
            $model->description = $request->description;                 
            $model->name = $request->name;  
            $model->address = $request->address;  
            $model->district = $request->district;  
            $model->zip_code = $request->zip_code;  
            $model->state_id = $request->state_id;  
            $model->city_id = $request->city_id;         
            
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
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function show(QuizAnswer $resposta)
    {
        try {
                      
            $item = $resposta;
            
            $campaigns = $this->campaign::all();
            $states = $this->state::all();
            
            $show = true;
                        
            return view($this->pathView.'form',compact('item','campaigns','states','show'));  
            
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
    public function edit(QuizAnswer $resposta)
    {
        try {
                      
            $item = $resposta;
            
            $campaigns = $this->campaign::all();
            $states = $this->state::all();
                        
            return view($this->pathView.'form',compact('item','campaigns','states'));  
            
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
    public function update(Request $request, QuizAnswer $resposta)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required',
            'quiz_option_id' =>  'required',
            'description' =>  'required',
            'name' =>  'required',
            'address' =>  'required',
            'district' =>  'required',
            'zip_code' =>  'required',
            'state_id' =>  'required',
            'city_id' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = $resposta;
            
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->quiz_question_id = $request->quiz_question_id;
            $model->quiz_option_id = $request->quiz_option_id;
            $model->description = $request->description;                 
            $model->name = $request->name;  
            $model->address = $request->address;  
            $model->district = $request->district;  
            $model->zip_code = $request->zip_code;  
            $model->state_id = $request->state_id; 
            $model->city_id = $request->city_id;          
            
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
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizAnswer $resposta)
    {
        try {
                      
            $resposta->delete();
            
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
}


