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
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $state;
    protected $city;
<<<<<<< HEAD

=======
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    public function __construct(District $model){
      $this->name = 'Bairro';
      $this->link = '/app/bairros';
      $this->pathView = 'app.district.';
<<<<<<< HEAD
      $this->model = $model;
=======
      $this->model = $model;      
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
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
<<<<<<< HEAD
        $items = $this->model::all();

        return response()->json(['data'=>$items]);

        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items'));
        }
=======
        $items = $this->model::all();       
        
        if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items'));
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
        $states = $this->state::all();

=======
    {  
        $states = $this->state::all();
        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        return view($this->pathView.'form',compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
<<<<<<< HEAD
    {
=======
    {        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        $rules = [
            'city_id' =>  'required',
            'name' =>  'required',
            'type' =>  'required'
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

=======
            }     
        } 
        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        try {
            $model = new $this->model;
            $model->city_id = $request->city_id;
            $model->name = $request->name;
<<<<<<< HEAD
            $model->type = $request->type;

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
            $model->type = $request->type;       
            
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
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function show(District $bairro)
    {
<<<<<<< HEAD

=======
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
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
<<<<<<< HEAD

            $item = $bairro;

            $states = $this->state::all();

            return view($this->pathView.'form',compact('item','states'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
                      
            $item = $bairro;
            
            $states = $this->state::all();
                        
            return view($this->pathView.'form',compact('item','states'));  
            
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
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $bairro)
    {
        $rules = [
            'city_id' =>  'required',
            'name' =>  'required',
            'type' =>  'required'
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

        try {
            $model = $bairro;

            $model->city_id = $request->city_id;
            $model->name = $request->name;
            $model->type = $request->type;

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
            }     
        } 
        
        try {
            $model = $bairro;
            
            $model->city_id = $request->city_id;
            $model->name = $request->name;
            $model->type = $request->type;          
            
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
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $bairro)
    {
        try {
<<<<<<< HEAD

            $bairro->delete();

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
                      
            $bairro->delete();
            
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
