<?php

namespace App\Controller\App;

use App\Domain\Person\Model\Person;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Carbon\Carbon;

class PersonController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    
    public function __construct(Person $model){
      $this->name = 'Pessoa';
      $this->link = '/app/pessoas';
      $this->pathView = 'app.person.';
      $this->model = $model;      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::all();
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
            'first_name' =>  'required',
            'last_name' =>  'required',
            'cpf' =>  'required|unique:people|max:100',
            'sex' =>  'required',
            'birth' => 'nullable|date_format:d/m/Y|before:'.Carbon::now()->subDays(6570)->format('d/m/Y'),
            'years_old' => 'nullable|integer',
        ]; 

        $this->validate($request, $rules);
        
        if(strlen($request->birth)>0){
          $data = explode('/',$request->birth);
          $request->birth = $data[2].'-'.$data[1].'-'.$data[0];
        }
        
        try {
            $model = new $this->model;
            $model->first_name = $request->first_name;
            $model->last_name = $request->last_name;
            $model->cpf = $request->cpf;    
            $model->sex = $request->sex;    
            $model->slug = str_slug(time().'-'.$request->first_name.'-'.$request->last_name);
            $model->nickname = $request->nickname;  
            $model->years_old = $request->years_old;   
            $model->birth = $request->birth;  
            $model->salary = $request->salary;  
            $model->education_level = $request->education_level;  
            $model->user_id = $request->user_id;      
            
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
     * @param  \App\Person  $model
     * @return \Illuminate\Http\Response
     */
    public function show(Person $pessoa)
    {
        try {
                      
            $item = $pessoa;
            
            $show = true;
                                    
            return view($this->pathView.'form',compact('item','show'));  
            
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
     * @param  \App\Person  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $pessoa)
    {
        try {
                      
            $item = $pessoa;
                                    
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
     * @param  \App\Person  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $pessoa)
    {
        $rules = [
            'first_name' =>  'required',
            'last_name' =>  'required',
            'cpf' =>  ['required','max:100',Rule::unique('people')->ignore($request->id)],
            'sex' =>  'required',
            'birth' => 'nullable|date_format:d/m/Y|before:'.Carbon::now()->subDays(6570)->format('d/m/Y'),
            'years_old' => 'nullable|integer',
        ]; 

        $this->validate($request, $rules);

        if(strlen($request->birth)>0){
          $data = explode('/',$request->birth);
          $request->birth = $data[2].'-'.$data[1].'-'.$data[0];
        }
                
        try {
            $model = $pessoa;
            
            $model->first_name = $request->first_name;
            $model->last_name = $request->last_name;
            $model->cpf = $request->cpf;    
            $model->sex = $request->sex;    
            $model->slug = str_slug(time().'-'.$request->first_name.'-'.$request->last_name);
            $model->nickname = $request->nickname;  
            $model->years_old = $request->years_old;   
            $model->birth = $request->birth;  
            $model->salary = $request->salary;  
            $model->education_level = $request->education_level;  
            $model->user_id = $request->user_id;              
            
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
     * @param  \App\Person  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $pessoa)
    {
        try {
                      
            $pessoa->delete();
            
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


