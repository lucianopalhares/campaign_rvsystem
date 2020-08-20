<?php

namespace App\Controller\App\Quiz;

use App\Domain\Quiz\Model\QuizCampaign;
use App\Domain\Quiz\Model\QuizQuestion;
use App\Domain\City\Model\District;
use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use \App;
use Illuminate\Support\Facades\Validator;

class ChartController extends Controller
{

    public $campaign;
    public $question;
    public $district;

    public function __construct(QuizCampaign $campaign, QuizQuestion $question, District $district){
      $this->campaign = $campaign;
      $this->question = $question;
      $this->district = $district;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request,$quizCampaignSlug)
    {
        /* inserir em todos metodos - inicio */
        $quizCampaign = request()->session()->get('quizCampaign');
        /* inserir em todos metodos - fim */

        try {

        $districts = $this->district ::whereHas('answers',function($query) use ($quizCampaign){
          $query->where('quiz_campaign_id',$quizCampaign->id);
        })->get();

        $allquestions = $this->question::whereHas('answers',function($query) use ($quizCampaign){
          $query->where('quiz_campaign_id',$quizCampaign->id);
        })->get();

        if(isset($request->perguntas)){

            $questions_array = [];

            $questions_params = explode(',',$request->perguntas);
            foreach ($questions_params as $key => $value) {

              $question = $this->question::whereId($value)->whereHas('answers',function($query) use ($quizCampaign){
                $query->where('quiz_campaign_id',$quizCampaign->id);
              })->first();

              if(isset($question->id)){
                $questions_array[] = $question;
              }
            }
            $questions = (object) $questions_array;

            $questions = collect($questions);

        }else{
            $questions = $this->question::whereHas('answers',function($query) use ($quizCampaign){
              $query->where('quiz_campaign_id',$quizCampaign->id);
            })->get();


        }

        foreach ($questions as $key => $question) {

          $answers = [];

          foreach ($question->answers->groupBy('description') as $answer => $campaign_answers) {

               $string = $answer;
               $string = strtolower(utf8_decode($string));

               $acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
               $sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
               $string = strtr($string, utf8_decode($acentos), $sem_acentos);

               $string = utf8_decode($string);
               $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");

               if(!array_key_exists($string,$answers)){
                 $answers[$string] = $campaign_answers->count();
               }else{
                 $answers[$string] = $answers[$string] + $campaign_answers->count();
               }
                //return $answer;
                //return $question->campaigns->groupBy('answer_description')[$k]->count();


          }

          $questions[$key]->answers_chart = (object) $answers;

        }
        return view('app.quiz.chart',compact('questions','quizCampaign','allquestions','districts'));

      } catch (\Exception $e) {//errors exceptions

          $response = null;

          switch (get_class($e)) {
            case QueryException::class:$response = $e->getMessage();
            case Exception::class:$response = $e->getMessage();
            case ValidationException::class:$response = $e;
            default: $response = get_class($e);
          }

          $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

          return response()->json(['status'=>false,'msg'=>$response]);

      }
    }
}
