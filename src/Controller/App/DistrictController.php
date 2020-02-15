<?php

namespace App\Controller\App;

use App\Domain\City\Model\District;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;

class DistrictController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $state;
    protected $city;
    
    public function __construct(District $model){
      $this->name = 'Bairro';
      $this->link = '/app/bairros';
      $this->pathView = 'app.district.';
      $this->model = $model;      
      $this->state = App::make("App\Domain\City\Model\State");
      $this->city = App::make("App\Domain\City\Model\City");
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
        $states = $this->state::all();
        
        return view($this->pathView.'form',compact('states'));
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
            'city_id' =>  'required',
            'name' =>  'required',
            'type' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = new $this->model;
            $model->city_id = $request->city_id;
            $model->name = $request->name;
            $model->type = $request->type;       
            
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
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function show(District $bairro)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(District $bairro)
    {
        try {
                      
            $item = $bairro;
            
            $states = $this->state::all();
                        
            return view($this->pathView.'form',compact('item','states'));  
            
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
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $bairro)
    {
        $rules = [
            'city_id' =>  'required',
            'name' =>  'required',
            'type' =>  'required'
        ]; 

        $this->validate($request, $rules);
        
        try {
            $model = $bairro;
            
            $model->city_id = $request->city_id;
            $model->name = $request->name;
            $model->type = $request->type;          
            
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
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $bairro)
    {
        try {
                      
            $bairro->delete();
            
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


