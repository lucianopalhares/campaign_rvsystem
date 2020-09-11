  <table>  

  <?php 

$cards = \App\Domain\Quiz\Model\Card::whereHas('answers',function($query) use ($quizCampaign){
  $query->where('quiz_campaign_id',$quizCampaign->id);
})->get();

?>


<tbody>

<tr>
<td>Entrevistado</td> 
@foreach($quizCampaign->questions as $k => $question)
     
    <td>{{$question->description}}</td> 
    
@endforeach
<td>Bairro</td> 
</tr>
    
@foreach($cards as $c => $card)

    <tr>

    <td>{{$card->name}}</td> 

    <?php 
      $answers = \App\Domain\Quiz\Model\QuizAnswer::whereQuizCampaignId($quizCampaign->id)->whereCardId($card->id)->get()->groupBy('quiz_question_id');
    ?>
    

    @foreach($quizCampaign->questions as $k => $question)

      @if(isset($answers[$question->id]))
        <td>{{$answers[$question->id][0]->description}}</td> 
      @else 
        <td></td>
      @endif
      
    @endforeach

    <td>{{isset($card->district_id)?$card->district->name:''}}</td> 

    </tr>
    
@endforeach

</tbody>

</table>