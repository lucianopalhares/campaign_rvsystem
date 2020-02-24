<?php

namespace App\Controller\App;

use App\Domain\Political\Model\Politic;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class PoliticController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $person;
    protected $city;
    protected $political_office;
    protected $political_party;
    
    public function __construct(Politic $model){
      $this->name = 'Politico';
      $this->link = '/app/politicos';
      $this->pathView = 'app.politic.';
      $this->model = $model;      
      $this->person = App::make("App\Domain\Person\Model\Person");
      $this->political_office = App::make("App\Domain\Political\Model\PoliticalOffice");
      $this->political_party = App::make("App\Domain\Political\Model\PoliticalParty");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::all();

        if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items'));
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $people = $this->person::all();
        $political_offices = $this->political_office::all();
        $political_parties = $this->political_party::all();
        
        return view($this->pathView.'form',compact('people','political_offices','political_parties'));
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
            'person_id' => 'required|unique:politics|max:100',
            'political_office_id' =>  'required',
            'political_party_id' =>  'required'
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
          
            $person = $this->person::find($request->person_id);
            
            $model = new $this->model;
            
            $model->person_id = $request->person_id;
            $model->slug = $person->slug;
            $model->political_office_id = $request->political_office_id;
            $model->political_party_id = $request->political_party_id;       
            
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
     * @param  \App\Politic  $model
     * @return \Illuminate\Http\Response
     */
    public function show(Politic $politico)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Politic  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Politic $politico)
    {
        try {
                      
            $item = $politico;
            
            $people = $this->person::all();
            $political_offices = $this->political_office::all();
            $political_parties = $this->political_party::all();
            
            return view($this->pathView.'form',compact('item','people','political_offices','political_parties'));
                    
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
     * @param  \App\Politic  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Politic $politico)
    {
        $rules = [
            'person_id' =>  ['required','max:100',Rule::unique('politics')->ignore($request->id)],
            'political_office_id' =>  'required',
            'political_party_id' =>  'required'
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
          
            $person = $this->person::find($request->person_id);
          
            $model = $politico;
            
            $model->person_id = $request->person_id;
            $model->slug = $person->slug;
            $model->political_office_id = $request->political_office_id;
            $model->political_party_id = $request->political_party_id;           
            
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
     * @param  \App\Politic  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Politic $politico)
    {
        try {
                      
            $politico->delete();
            
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


