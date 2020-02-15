<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizCampaign;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class QuizCampaignController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $question;
    
    public function __construct(QuizCampaign $model){
      $this->name = 'Campanha';
      $this->link = '/app/campanhas';
      $this->pathView = 'app.campaign.';
      $this->model = $model;
      //$this->question = App::make("App\Domain\Quiz\Model\QuizQuestion");
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
        return view($this->pathView.'form');
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
            'description' =>  'required',
            'slug' =>  'required',
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = new $this->model;
            $model->description = $request->description;
            $model->active = $request->active;
            $model->slug = $request->slug;
            
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
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function show(QuizCampaign $campanha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizCampaign $campanha)
    {
        try {
                      
            $item = $campanha;
                        
            return view($this->pathView.'form',compact('item'));  
            
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
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizCampaign $campanha)
    {
        $rules = [
          'description' =>  'required',
          'slug' =>  'required'
        ];  
        
        $this->validate($request, $rules);
        
        try {
          
            $model = $campanha;
            
            $model->description = $request->description;
            $model->active = $request->active;
            $model->slug = $request->slug;
            
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
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizCampaign $campanha)
    {
        try {
                      
            $campanha->delete();
            
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
    public function questions(QuizCampaign $campanha){
      return response()->json($campanha->questions);
    }
}


