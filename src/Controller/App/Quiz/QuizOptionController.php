<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizOption;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class QuizOptionController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $campaign;
    
    public function __construct(QuizOption $model){
      $this->name = 'Opção';
      $this->link = '/app/quiz/opcoes';
      $this->pathView = 'app.option.';
      $this->model = $model;
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");
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
        
        return view($this->pathView.'form',compact('campaigns'));
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
            'description' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = new $this->model;
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->quiz_question_id = $request->quiz_question_id;
            $model->description = $request->description;            
            
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
    public function edit(QuizOption $opco)
    {
        try {
                      
            $item = $opco;
            
            $campaigns = $this->campaign::all();
                        
            return view($this->pathView.'form',compact('item','campaigns'));  
            
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
     * @param  \App\QuizOption  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizOption $opco)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required',
            'description' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = $opco;
            
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->quiz_question_id = $request->quiz_question_id;
            $model->description = $request->description;            
            
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
     * @param  \App\QuizOption  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizOption $opco)
    {
        try {
                      
            $opco->delete();
            
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


