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
use Illuminate\Support\Facades\Validator;

class QuizCampaignController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $state;
<<<<<<< HEAD

=======
    
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    public function __construct(QuizCampaign $model){
      $this->name = 'Campanha';
      $this->link = '/app/campanhas';
      $this->pathView = 'app.campaign.';
      $this->model = $model;
      $this->state = App::make("App\Domain\City\Model\State");
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
=======
        
        if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items'));
        }
<<<<<<< HEAD

=======
        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
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
<<<<<<< HEAD
    {
=======
    {        
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
        $rules = [
            'description' =>  'required',
            'state_id' =>  'required',
            'city_id' =>  'required',
            'slug' => 'required|unique:quiz_campaigns|max:100',
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
            $model->description = $request->description;
            $model->active = $request->active;
            $model->slug = str_slug($request->slug);
            $model->state_id = $request->state_id;
            $model->city_id = $request->city_id;
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
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function show(QuizCampaign $campanha)
    {
        try {
<<<<<<< HEAD

          $item = $campanha;

          return response()->json(['data'=>$item]);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
          
          $item = $campanha;
          
          return response()->json(['data'=>$item]);
            
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizCampaign $campanha)
    {
        try {
<<<<<<< HEAD

            $item = $campanha;
            $states = $this->state::all();

            return view($this->pathView.'form',compact('item','states'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

=======
                      
            $item = $campanha;
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
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizCampaign $campanha)
    {
        $rules = [
          'description' =>  'required',
          'state_id' =>  'required',
          'city_id' =>  'required',
          'slug' =>  ['required','max:100',Rule::unique('quiz_campaigns')->ignore($request->id)],
<<<<<<< HEAD
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
=======
        ];  
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
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

            $model = $campanha;

=======
            }     
        } 
        
        try {
          
            $model = $campanha;
            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            $model->description = $request->description;
            $model->active = $request->active;
            $model->slug = str_slug($request->slug);
            $model->state_id = $request->state_id;
            $model->city_id = $request->city_id;
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
     * @param  \App\QuizCampaign  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizCampaign $campanha)
    {
        try {
<<<<<<< HEAD

            $campanha->delete();

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
                      
            $campanha->delete();
            
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
=======
            }              
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    }
    public function questions(QuizCampaign $campanha){
      return response()->json($campanha->questions);
    }

}
<<<<<<< HEAD
=======


>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
