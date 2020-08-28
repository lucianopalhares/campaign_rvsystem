<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizOption;
use App\Domain\Quiz\Model\QuizCampaign;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class QuizOptionController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $campaign;
    protected $question;
    protected $quizCampaignSlug;
    protected $state;
    protected $politic;
    protected $city;
    protected $district;
    protected $person;

    public function __construct(){
      $this->name = 'Opção';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.option.';
      $this->model = App::make("App\Domain\Quiz\Model\QuizOption");
      $this->question = App::make("App\Domain\Quiz\Model\QuizQuestion");
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");
      $this->political_party = App::make("App\Domain\Political\Model\PoliticalParty");
      $this->politic = App::make("App\Domain\Political\Model\Politic");
      $this->state = App::make("App\Domain\City\Model\State");
      $this->city = App::make("App\Domain\City\Model\City");
      $this->district = App::make("App\Domain\City\Model\District");
      $this->person = App::make("App\Domain\Person\Model\Person");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($quizCampaignSlug, Request $request)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/opcoes';
        /* inserir em todos metodos - fim */

        $items = $this->model::whereQuizCampaignId($quizCampaign->id)->get();

        if($request->has('quiz_question_id')){
          $items = $this->model::whereQuizQuestionId($request->quiz_question_id)->whereQuizCampaignId($quizCampaign->id)->get();
        }

        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          return response()->json(['data'=>$items]);
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
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */

        $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->whereOptionsRequired('1')->get();

        $people = $this->person::all();
        $political_parties = $this->political_party::all();
        $politics = $this->politic::with('political_office')->get();
        $states = $this->state::all();
        $cities = $this->city::with('state')->get();
        $districts = $this->district::with('city','city.state')->get();

        return view($this->pathView.'form',compact('quizCampaign','questions','political_parties','politics','states','cities','districts','people'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quizCampaignSlug)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required'
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

        if(!$request->quiz_optionable_id||!$request->quiz_optionable_type||!$request->quiz_optionable_name){
            $request->quiz_optionable_id = null;
            $request->quiz_optionable_type = null;
            $request->quiz_optionable_name = null;
        }

        if(!$request->quiz_optionable_id&&strlen($request->description)==0){
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>'Preencha a Descrição 1 ou a Descrição 2']);
            }else{
              return redirect()->back()
                        ->withErrors('Preencha a Descrição 1 ou a Descrição 2')
                        ->withInput();
            }
        }

        try {
            $model = new $this->model;
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->quiz_optionable_id = $request->quiz_optionable_id;
            $model->quiz_optionable_type = $request->quiz_optionable_type;
            $model->quiz_optionable_name = $request->quiz_optionable_name;
            $model->quiz_question_id = $request->quiz_question_id;

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
    public function edit($quizCampaignSlug, QuizOption $opco)
    {
        try {
          /* inserir em todos metodos - inicio */
          $quizCampaign = request()->session()->get('quizCampaign');
          $this->link .= $quizCampaign->slug.'/questoes';
          /* inserir em todos metodos - fim */

          $item = $opco;

          $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->whereOptionsRequired('1')->get();

          $people = $this->person::all();
          $political_parties = $this->political_party::all();
          $politics = $this->politic::with('political_office')->get();
          $states = $this->state::all();
          $cities = $this->city::with('state')->get();
          $districts = $this->district::with('city','city.state')->get();

          return view($this->pathView.'form',compact('item','quizCampaign','questions','political_parties','politics','states','cities','districts','people'));


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
    public function update(Request $request, $quizCampaignSlug, QuizOption $opco)
    {
        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id'=>  'required'
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

        if(!$request->quiz_optionable_id||!$request->quiz_optionable_type||!$request->quiz_optionable_name){
            $request->quiz_optionable_id = null;
            $request->quiz_optionable_type = null;
            $request->quiz_optionable_name = null;
        }

        if(!$request->quiz_optionable_id&&strlen($request->description)==0){
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>'Preencha a Descrição 1 ou a Descrição 2']);
            }else{
              return redirect()->back()
                        ->withErrors('Preencha a Descrição 1 ou a Descrição 2')
                        ->withInput();
            }
        }

        try {
            $model = $opco;

            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->quiz_optionable_id = $request->quiz_optionable_id;
            $model->quiz_optionable_type = $request->quiz_optionable_type;
            $model->quiz_optionable_name = $request->quiz_optionable_name;
            $model->quiz_question_id = $request->quiz_question_id;

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
     * @param  \App\QuizOption  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizCampaignSlug, QuizOption $opco)
    {
        try {

            $opco->delete();

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
