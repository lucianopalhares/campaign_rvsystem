<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizAnswer;
use App\Domain\Quiz\Model\QuizCampaign;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class QuizAnswerController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $campaign;
    protected $question;
    protected $option;
    protected $quizCampaignSlug;
    protected $state;
    protected $politic;
    protected $city;
    protected $district;
    protected $card;

    public function __construct(QuizAnswer $model){
      $this->name = 'Resposta';
      $this->link = '/app/campanha/';
      $this->pathView = 'app.quiz.answer.';
      $this->model = App::make("App\Domain\Quiz\Model\QuizAnswer");
      $this->option = App::make("App\Domain\Quiz\Model\QuizOption");
      $this->question = App::make("App\Domain\Quiz\Model\QuizQuestion");
      $this->campaign = App::make("App\Domain\Quiz\Model\QuizCampaign");
      $this->political_party = App::make("App\Domain\Political\Model\PoliticalParty");
      $this->politic = App::make("App\Domain\Political\Model\Politic");
      $this->state = App::make("App\Domain\City\Model\State");
      $this->city = App::make("App\Domain\City\Model\City");
      $this->district = App::make("App\Domain\City\Model\District");
      $this->card = App::make("App\Domain\City\Model\Card");
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
        if($request->has('quiz_option_id')){
          $items = $this->model::whereQuizOptionId($request->quiz_option_id)->whereQuizCampaignId($quizCampaign->id)->get();
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

        $states = $this->state::all();
        $districts = $this->district::whereQuizCampaignId($quizCampaign->id)->get();
        $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->get();

        return view($this->pathView.'form',compact('quizCampaign','states','questions','districts'));

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
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */

      $is_api = false;
      if(request()->wantsJson() or str_contains(url()->current(), 'api')){
        $is_api = true;
      }
      //salvar api - start
      if ($is_api) {
        if(isset($request->info_pesquisa)&&is_array($request->info_pesquisa)&&count($request->info_pesquisa)>0){
          isset($request->info_pesquisa['quiz_campaign_id'])?$request->merge([ 'quiz_campaign_id' => $request->info_pesquisa['quiz_campaign_id'] ]):'';
          isset($request->info_pesquisa['name'])?$request->merge([ 'name' => $request->info_pesquisa['name'] ]):'';
          //isset($request->info_pesquisa['city_id'])?$request->merge([ 'city_id' => $request->info_pesquisa['city_id'] ]):'';
          //isset($request->info_pesquisa['state_id'])?$request->merge([ 'state_id' => $request->info_pesquisa['state_id'] ]):'';
          isset($request->info_pesquisa['district_id'])?$request->merge([ 'district_id' => $request->info_pesquisa['district_id'] ]):'';
          isset($request->info_pesquisa['address'])?$request->merge([ 'address' => $request->info_pesquisa['address'] ]):'';
          isset($request->info_pesquisa['zip_code'])?$request->merge([ 'zip_code' => $request->info_pesquisa['zip_code'] ]):'';
          isset($request->info_pesquisa['latitude'])?$request->merge([ 'latitude' => $request->info_pesquisa['latitude'] ]):'';
          isset($request->info_pesquisa['longitude'])?$request->merge([ 'longitude' => $request->info_pesquisa['longitude'] ]):'';
        }
      }

      //salvar api - end

        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required',
            //'quiz_option_id' =>  'required',
            //'description' =>  'required',
            'name' =>  'required',
            //'address' =>  'required',
            //'district' =>  'required',
            //'zip_code' =>  'required',
            //'state_id' =>  'required',
            //'city_id' =>  'required'
        ];
        if (!$is_api) {
          $validator = Validator::make($request->all(), $rules);

          if ($validator->fails()) {
              if ($is_api) {
                //nao valida via api
                //return response()->json(['status'=>false,'msg'=>$validator->errors()]);
              }else{
                return redirect()->back()
                          ->withErrors($validator->errors())
                          ->withInput();
              }
          }
        }

        try {

            if(!$is_api){

              $pesquisa_respostas = [];
              $pesquisa_respostas[] = ['quiz_question_id'=>$request->quiz_question_id,'resposta_id'=>$request->quiz_option_id,'resposta'=>$request->description];

              $request->merge([ 'pesquisa_respostas' => $pesquisa_respostas ]);
            }

            foreach ($request->pesquisa_respostas as $pesquisa_resposta) {

              $type = $this->question::findOrFail($pesquisa_resposta['quiz_question_id'])->type;

              $error = '';

              if($type=='0'){

                if(isset($pesquisa_resposta['respostas'])&&is_array($pesquisa_resposta['respostas'])){

                  if(count($pesquisa_resposta['respostas'])==0){
                    $error = 'Marque uma opção para a pergunta';
                  }elseif(count($pesquisa_resposta['respostas'])>1){
                    $error = 'Deve escolher apenas uma opção para a pergunta';
                  }

                }else{
                  $error = 'Marque uma opção para a pergunta';
                }

              }elseif($type=='1'){

                if(isset($pesquisa_resposta['respostas'])&&is_array($pesquisa_resposta['respostas'])){

                  if(count($pesquisa_resposta['respostas'])==0){
                    $error = 'Marque as opções para a pergunta';
                  }elseif(count($pesquisa_resposta['respostas'])==1){
                    $error = 'Deve escolher mais de uma opção para a pergunta';
                  }

                }else{
                  $error = 'Marque as opções para a pergunta';
                }

              }elseif($type=='2'){

                if(isset($pesquisa_resposta['respostas'])&&is_array($pesquisa_resposta['respostas'])){

                  if(count($pesquisa_resposta['respostas'])==0){
                    $error = 'Digite uma resposta para a pergunta';
                  }elseif(count($pesquisa_resposta['respostas'])>1){
                    $error = 'Deve escolher apenas uma opção para a pergunta';
                  }else{
                    if(!isset($pesquisa_resposta['respostas'][0]['resposta'])||strlen($pesquisa_resposta['respostas'][0]['resposta'])==0){
                      $error = 'Digite a resposta para a pergunta';
                    }
                    $pesquisa_resposta['respostas'][0]['resposta_id'] = null;
                  }

                }else{
                  $error = 'Digite uma resposta para a pergunta';
                }

              }else{
                $error = 'Pergunta não foi especificada quantas opções para selecionar.';
              }

              if(strlen($error)>0){
                if ($is_api) {

                  return response()->json(['status'=>false,'msg'=>$error]);
                }else{
                  return redirect()->back()
                            ->withErrors($error)
                            ->withInput();
                }
              }

              $card = new $this->card;
              $card->quiz_campaign_id = $request->quiz_campaign_id;
              $card->name = $request->name;
              $card->district_id = $request->district_id;
              $card->address = $request->address;
              $card->zip_code = $request->zip_code;
              $card->latitude = $request->latitude;
              $card->longitude = $request->longitude;
              $card->save();

              foreach ($pesquisa_resposta['respostas'] as $key => $resposta) {

                if($type!='2'){
                  $option = $this->option::findOrFail($resposta['resposta_id']);
                  $resposta['resposta'] = $option->description;
                }else{
                  $resposta['resposta_id'] = null;
                }                

                $model = new $this->model;

                $model->quiz_campaign_id = $request->quiz_campaign_id;
                $model->quiz_question_id = $pesquisa_resposta['quiz_question_id'];
                $model->description = $resposta['resposta'];
                $model->quiz_option_id = $resposta['resposta_id'];
                $model->name = $request->name;
                //$model->state_id = $quizCampaign->state_id;
                //$model->city_id = $quizCampaign->city_id;
                $model->district_id = $request->district_id;
                $model->address = $request->address;
                $model->zip_code = $request->zip_code;
                $model->latitude = $request->latitude;
                $model->longitude = $request->longitude;

                $model->card_id = $card->id;

                $save = $model->save();
              }
            }

            $response = $this->name;

            $response .= ' Cadastrado(a) com Sucesso!';

            if ($is_api) {
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

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function show($quizCampaignSlug, QuizAnswer $resposta)
    {
        try {

            $item = $resposta;

            /* inserir em todos metodos - inicio */
            $quizCampaign = request()->session()->get('quizCampaign');
            $this->link .= $quizCampaign->slug.'/questoes';
            /* inserir em todos metodos - fim */

            $states = $this->state::all();
            $districts = $this->district::whereQuizCampaignId($quizCampaign->id)->get();
            $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->get();

            $show = true;

            return view($this->pathView.'form',compact('item','quizCampaign','states','show','questions','districts'));

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
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($quizCampaignSlug, QuizAnswer $resposta)
    {
        try {

            $item = $resposta;

            /* inserir em todos metodos - inicio */
            $quizCampaign = request()->session()->get('quizCampaign');
            $this->link .= $quizCampaign->slug.'/questoes';
            /* inserir em todos metodos - fim */

            $states = $this->state::all();
            $districts = $this->district::whereQuizCampaignId($quizCampaign->id)->get();
            $questions = $this->question::whereQuizCampaignId($quizCampaign->id)->get();

            return view($this->pathView.'form',compact('item','quizCampaign','states','questions','districts'));

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
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quizCampaignSlug, QuizAnswer $resposta)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */

        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required',
            //'quiz_option_id' =>  'required',
            //'description' =>  'required',
            'name' =>  'required',
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

            if($this->question::findOrFail($request->quiz_question_id)->options_required){
              if(!$request->quiz_option_id){
                if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
                  return response()->json(['status'=>false,'msg'=>'Escolha uma Opção como Resposta ou aguarde o cadastro de novas opções (questão multipla escolha)']);
                }else{

                  return back()->withInput($request->toArray())->withErrors('Escolha uma Opção como Resposta ou aguarde o cadastro de novas opções (questão multipla escolha)');
                }
              }
            }else{
              if(strlen($request->description)==0){
                if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
                  return response()->json(['status'=>false,'msg'=>'Responda a Questão na DESCRIÇÃO, não é multipla escolha (não tem opções cadastradas para esta questão)']);
                }else{

                  return back()->withInput($request->toArray())->withErrors('Responda a Questão na DESCRIÇÃO, não é multipla escolha (não tem opções cadastradas para esta questão)');
                }
              }
            }

            $model = $resposta;

            $model->quiz_campaign_id = $request->quiz_campaign_id;
            $model->quiz_question_id = $request->quiz_question_id;
            $model->description = $request->description;
            $model->quiz_option_id = $request->quiz_option_id;
            $model->name = $request->name;
            //$model->state_id = $quizCampaign->state_id;
            //$model->city_id = $quizCampaign->city_id;
            $model->district_id = $request->district_id;
            $model->address = $request->address;
            $model->zip_code = $request->zip_code;
            $model->latitude = $request->latitude;
            $model->longitude = $request->longitude;

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
     * @param  \App\QuizAnswer  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($quizCampaignSlug, QuizAnswer $resposta)
    {
        try {

            $resposta->delete();

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
    public function responderPerguntas(Request $request, $quizCampaignSlug){

        $quizCampaign = request()->session()->get('quizCampaign');

        $states = $this->state::all();
        $districts = $this->district::whereQuizCampaignId($quizCampaign->id)->get();

        if($request->has('answer')){
          $answer = $this->model::findOrFail($request->answer);

          $question = $this->question::whereDoesntHave('answers',function($query) use ($answer){
            $query->where('quiz_campaign_id',$answer->quiz_campaign_id);
            $query->where('name',$answer->name);
          })->first();


          if(isset($question->id)){

            return view('app.quiz.answer.answerAll.formQuestion',compact('quizCampaign','states','question','districts','answer'));

          }else{
            
            $question = $this->question::first();
            return view('app.quiz.answer.answerAll.formQuestion',compact('quizCampaign','states','question','districts'));

          }




        }else{

          $question = $this->question::first();

          return view('app.quiz.answer.answerAll.formQuestion',compact('quizCampaign','states','question','districts'));

        }


    }
    public function responderPergunta(Request $request)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        $this->link .= $quizCampaign->slug.'/questoes';
        /* inserir em todos metodos - fim */

        $rules = [
            'quiz_campaign_id' =>  'required',
            'quiz_question_id' =>  'required',
            //'quiz_option_id' =>  'required',
            //'description' =>  'required',
            'name' =>  'required',
            //'address' =>  'required',
            //'district' =>  'required',
            //'zip_code' =>  'required',
            //'state_id' =>  'required',
            //'city_id' =>  'required'
        ];

          $validator = Validator::make($request->all(), $rules);

          if ($validator->fails()) {
              return redirect()->back()
                      ->withErrors($validator->errors())
                      ->withInput();
          }


        try {

              $type = $this->question::findOrFail($request->quiz_question_id)->type;

              $error = '';

              if($type=='0'){

                if(count($request->options)>1){
                  $error = 'Escolha apenas uma opção';
                }

              }elseif($type=='1'){



              }elseif($type=='2'){

                if(!$request->has('description')or strlen($request->description)==0){
                  $error = 'Digite a descrição da resposta';
                }

              }else{
                $error = 'Pergunta não foi especificada quantas opções para selecionar.';
              }

              if(strlen($error)>0){

                  return redirect()->back()
                          ->withErrors($error)
                          ->withInput();
              }

              $answer = null;

              if($type=='0' or $type=='1'){

                foreach ($request->options as $option) {

                  $optionFind = $this->option::findOrFail($option);

                  $model = new $this->model;

                  $model->quiz_campaign_id = $request->quiz_campaign_id;
                  $model->quiz_question_id = $request->quiz_question_id;
                  $model->description = $optionFind->description;
                  $model->quiz_option_id = $option;
                  $model->name = $request->name;
                  //$model->state_id = $quizCampaign->state_id;
                  //$model->city_id = $quizCampaign->city_id;
                  $model->district_id = $request->district_id;
                  $model->address = $request->address;
                  $model->zip_code = $request->zip_code;
                  $model->latitude = $request->latitude;
                  $model->longitude = $request->longitude;

                  $model->save();

                  $answer = $model->id;
                }
              }else{

                $model = new $this->model;

                $model->quiz_campaign_id = $request->quiz_campaign_id;
                $model->quiz_question_id = $request->quiz_question_id;
                $model->description = $request->description;
                $model->quiz_option_id = null;
                $model->name = $request->name;
                //$model->state_id = $quizCampaign->state_id;
                //$model->city_id = $quizCampaign->city_id;
                $model->district_id = $request->district_id;
                $model->address = $request->address;
                $model->zip_code = $request->zip_code;
                $model->latitude = $request->latitude;
                $model->longitude = $request->longitude;

                $model->save();

                $answer = $model->id;
              }

            $response = 'Pergunta Respondida com Sucesso!';

            return redirect('app/campanha/'.$quizCampaign->slug.'/responder-perguntas?answer='.$answer)->with('success', $response);



        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            return back()->withInput($request->toArray())->withErrors($response);

        }
    }
}
