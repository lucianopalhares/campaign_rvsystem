<table>  

<?php 

$min = 1500;
$max = 3500;

$total_questions = $quizCampaign->questions->count();

$answers = \App\Domain\Quiz\Model\QuizAnswer::whereQuizCampaignId($quizCampaign->id)->select('description','quiz_question_id')->get()->groupBy('quiz_question_id');
$total_answers = 0; 

$answers_printed = 0;

$min_answers = 0;
$max_answers = 0;

$districts = \App\Domain\City\Model\District::whereHas('answers',function($query) use ($quizCampaign){
$query->where('quiz_campaign_id',$quizCampaign->id);
})->get();
$answersDistricts = \App\Domain\Quiz\Model\QuizAnswer::whereQuizCampaignId($quizCampaign->id)->select('district_id')->get();

//dd($districts);
?>


<tbody>

@foreach($quizCampaign->questions as $k => $question)
  @if ($loop->first)
      <tr>
  @endif
  
  <td>            
      {{ $answers[$question->id][0]->question->description }}

     
      <?php 

        if($max_answers<$answers[$question->id]->count()){
          $max_answers = $answers[$question->id]->count();
        }
        if($min_answers==0){
          $min_answers = $answers[$question->id]->count();
        }else{
          if($answers[$question->id]->count()<$min_answers){
            $min_answers = $answers[$question->id]->count();
          }
        }

        $total_answers += $answers[$question->id]->count();  
      
      ?>
  </td>
  
@endforeach

  
  <td>Bairro</td> 
  </tr>

@for($c = 0; $c < $max_answers; $c++)

<tr>

@foreach($quizCampaign->questions as $k => $question)

  @if(isset($answers[$question->id][$c]) && strlen($answers[$question->id][$c]->description)>0)

    <td>{{$answers[$question->id][$c]->description}}</td> 

    <?php
        $answers_printed++;
    ?>

  @else 
    <td></td>
  @endif

@endforeach

  @if(isset($answersDistricts[$c]) && $answersDistricts[$c]->district_id>0)

  <td>{{$answersDistricts[$c]->district->name}}</td> 

  <?php
      $answers_printed++;
  ?>

  @else 
  <td></td>
  @endif


                 
  </tr>


@endfor

</tbody>

</table>