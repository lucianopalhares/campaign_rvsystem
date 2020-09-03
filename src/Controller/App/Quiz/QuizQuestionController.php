<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizQuestion;
use App\Domain\Quiz\Model\QuizCampaign;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class QuizQuestionController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $option;
    protected $campaign;
    protected $quizCampaignSlug;
    protected $state;
    protected $politic;
    protected $city;
    protected $district;
    protected $person;

    public function __construct(){
      $this->name = 'Questão';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.question.';
      $this->model = App::make("App\Domain\Quiz\Model\QuizQuestion");
      $this->option = App::make("App\Domain\Quiz\Model\QuizOption");
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
    public function index($quizCampaignSlug)
    {       

        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */

        $items = $this->model::whereQuizCampaignId($quizCampaign->id)->get();

        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          $items = $this->model::with('options','answers')->whereQuizCampaignId($quizCampaign->id)->get();
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
    public function create($quizCampaignSlug)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */

        $people = $this->person::all();
        $political_parties = $this->political_party::all();
        $politics = $this->politic::with('office')->get();
        $states = $this->state::all();
        $cities = $this->city::with('state')->get();
        $districts = $this->district::with('city','city.state')->get();

        return view($this->pathView.'form',compact('quizCampaign','political_parties','politics','states','cities','districts','people'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quizCampaignSlug)
    {



        $validator = Validator::make($request->all(), [
            'quiz_campaign_id' =>  'required',
            'description' =>  'required'
        ]);

        if ($validator->fails()) {
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        if(!$request->quiz_questionable_id||!$request->quiz_questionable_type||!$request->quiz_questionable_name){
            $request->quiz_questionable_id = null;
            $request->quiz_questionable_type = null;
            $request->quiz_questionable_name = null;
        }

        try {
            $model = new $this->model;
            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->options_required = $request->options_required;
            $model->type = $request->type;
            $model->quiz_questionable_id = $request->quiz_questionable_id;
            $model->quiz_questionable_type = $request->quiz_questionable_type;
            $model->quiz_questionable_name = $request->quiz_questionable_name;

            $model->save();

            if(isset($request->options)&&is_array($request->options)&&count($request->options)>0){

                foreach($request->options as $i => $option)
                {
                  if(strlen($option)>0){

                    $quiz_option = new $this->option;
                    $quiz_option->description = $option;
                    $quiz_option->quiz_campaign_id = $request->quiz_campaign_id;
                    $quiz_option->quiz_question_id = $model->id;
                    $quiz_option->save();
                  }
                }
            }

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
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function show(QuizQuestion $questo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($quizCampaignSlug, QuizQuestion $questo)
    {
        try {
          /* inserir em todos metodos - inicio */
          $quizCampaign = request()->session()->get('quizCampaign');
          $this->link .= $quizCampaign->slug.'/questoes';
          /* inserir em todos metodos - fim */

          $item = $questo;

          $people = $this->person::all();
          $political_parties = $this->political_party::all();
          $politics = $this->politic::with('office')->get();
          $states = $this->state::all();
          $cities = $this->city::with('state')->get();
          $districts = $this->district::with('city','city.state')->get();

          return view($this->pathView.'form',compact('item','quizCampaign','political_parties','politics','states','cities','districts','people'));


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
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quizCampaignSlug, QuizQuestion $questo)
    {
        $validator = Validator::make($request->all(), [
            'quiz_campaign_id' =>  'required',
            'description' =>  'required'
        ]);

        if ($validator->fails()) {
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        if(!$request->quiz_questionable_id||!$request->quiz_questionable_type||!$request->quiz_questionable_name){
            $request->quiz_questionable_id = null;
            $request->quiz_questionable_type = null;
            $request->quiz_questionable_name = null;
        }

        try {
            $model = $questo;

            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->description = $request->description;
            $model->options_required = $request->options_required;
            $model->type = $request->type;
            $model->quiz_questionable_id = $request->quiz_questionable_id;
            $model->quiz_questionable_type = $request->quiz_questionable_type;
            $model->quiz_questionable_name = $request->quiz_questionable_name;

            $model->save();

            if(isset($request->options)&&is_array($request->options)&&count($request->options)>0){

                foreach($request->options as $i => $option)
                {
                  if(strlen($option)>0){

                    $quiz_option = new $this->option;
                    $quiz_option->description = $option;
                    $quiz_option->quiz_campaign_id = $request->quiz_campaign_id;
                    $quiz_option->quiz_question_id = $model->id;
                    $quiz_option->save();
                  }
                }
            }

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
     * @param  \App\QuizQuestion  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizCampaignSlug, QuizQuestion $questo)
    {
        try {

            $questo->delete();

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
    public function options(QuizQuestion $questo){

      $data = [];
      $data['quiz_question'] = $questo;
      $data['data'] = [];
      foreach ($questo->options as $option) {
        $description = '';
        if($option->description){
          $description = $option->description;
        }
        if($option->quiz_optionable_id){
          $description .= ' '.$option->quiz_optionable->nable();
        }
        $insert['description'] = $description;
        $insert['id'] = $option->id;
        $data['data'][] = $insert;
      }
      return response()->json($data);
    }
    public function excel($quizCampaignSlug){

      /* inserir em todos metodos - inicio */
      $quizCampaign = request()->session()->get('quizCampaign');
      /* inserir em todos metodos - fim */

      return Excel::download(new \App\Job\QuestionsExcel($quizCampaign), 'questions.xlsx');

    }
    public function pageExcel($quizCampaignSlug){

      /* inserir em todos metodos - inicio */
      $quizCampaign = request()->session()->get('quizCampaign');
      /* inserir em todos metodos - fim */

      return view($this->pathView.'questions-answers',compact('quizCampaign'));
    }
}
