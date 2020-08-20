<?php

namespace App\Controller\App;

use App\Domain\Political\Model\PoliticalParty;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class PoliticalPartyController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $person;
    protected $city;
    protected $political_office;
    protected $political_party;
<<<<<<< HEAD

=======
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    public function __construct(PoliticalParty $model){
      $this->name = 'Partido Politico';
      $this->link = '/app/partido-politicos';
      $this->pathView = 'app.political_party.';
<<<<<<< HEAD
      $this->model = $model;
=======
      $this->model = $model;      
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
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
<<<<<<< HEAD

        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items'));
        }
=======
        
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
=======
    {  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        return view($this->pathView.'form');
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
        $rules = [
            'name' => 'required|unique:political_parties|max:100',
        ];
=======
    {        
        $rules = [
            'name' => 'required|unique:political_parties|max:100',
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
            $model = new $this->model;

            $model->name = $request->name;
            $model->slug = str_slug($request->name);

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
            }     
        } 
                
        try {
            $model = new $this->model;
            
            $model->name = $request->name;
            $model->slug = str_slug($request->name);       
            
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
     * @param  \App\PoliticalParty  $model
     * @return \Illuminate\Http\Response
     */
    public function show(PoliticalParty $partido_politico)
    {
<<<<<<< HEAD

=======
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PoliticalParty  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(PoliticalParty $partido_politico)
    {
        try {
<<<<<<< HEAD

            $item = $partido_politico;

            return view($this->pathView.'form',compact('item'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
                      
            $item = $partido_politico;
                        
            return view($this->pathView.'form',compact('item'));
                    
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
     * @param  \App\PoliticalParty  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PoliticalParty $partido_politico)
    {
        $rules = [
            'name' =>  ['required','max:100',Rule::unique('political_parties')->ignore($request->id)],
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
            $model = $partido_politico;

            $model->name = $request->name;
            $model->slug = str_slug($request->name);

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
            $model = $partido_politico;
            
            $model->name = $request->name;
            $model->slug = str_slug($request->name);        
            
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
     * @param  \App\PoliticalParty  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(PoliticalParty $partido_politico)
    {
        try {
<<<<<<< HEAD

            $partido_politico->delete();

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
                      
            $partido_politico->delete();
            
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
