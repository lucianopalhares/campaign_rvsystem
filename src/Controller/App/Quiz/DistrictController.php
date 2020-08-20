<?php

namespace App\Controller\App\Quiz;

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
    protected $campaign;

    public function __construct(District $model){
      $this->name = 'Bairro';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.district.';
      $this->model = $model;
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");
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
        $this->link .= $quizCampaign->slug.'/bairros';
        /* inserir em todos metodos - fim */

        $items = $this->model::with('city')->whereQuizCampaignId($quizCampaign->id)->get();
        //return response()->json($items);
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          return response()->json($items);
        }else{
          return view($this->pathView.'index',compact('items','quizCampaign'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/bairros';
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
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/bairros';
        /* inserir em todos metodos - fim */

        $rules = [
            'city_id' =>  'required',
            'name' =>  'required',
            'quiz_campaign_id' =>  'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        try {
            $model = new $this->model;
            $model->city_id = $quizCampaign->city_id;
            $model->quiz_campaign_id = $quizCampaign->id;
            $model->name = $request->name;

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

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
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
    public function show($quizCampaignSlug,District $bairro)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($quizCampaignSlug,District $bairro)
    {
        try {
            /* inserir em todos metodos - inicio */
            $quizCampaign = request()->session()->get('quizCampaign');
            $this->link .= $quizCampaign->slug.'/bairros';
            /* inserir em todos metodos - fim */

            $item = $bairro;

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
     * @param  \App\District  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quizCampaignSlug, District $bairro)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/bairros';
        /* inserir em todos metodos - fim */

        $rules = [
            'city_id' =>  'required',
            'name' =>  'required',
            'quiz_campaign_id' =>  'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        try {
            $model = $bairro;

            $model->city_id = $quizCampaign->city_id;
            $model->quiz_campaign_id = $quizCampaign->id;
            $model->name = $request->name;

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

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
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
    public function destroy($quizCampaignSlug, District $bairro)
    {
        try {

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

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }

            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }

        }
    }
}
