<?php 
    $search = \App\Domain\Quiz\Model\QuizAnswer::whereQuizCampaignId($quizCampaign->id)->whereBetween('id', [1500, 3000])->get()->groupBy('quiz_question_id');
    $total_answers = 0; 
    $g = 0;
?>
    
<table>
    <tbody>
   <!-- $quizCampaign->answers->groupBy('quiz_question_id')-->
    @foreach($search as $question_id => $answers)
        @if ($loop->first)
            <tr>
        @endif
        
        <td>            
            {{ $answers[0]->question->description }}
            <?php $total_answers += $answers->count();  ?>
        </td>
        
        @if ($loop->last)
            </tr>
        @endif
    @endforeach

    dd($total_answers);

    @for($c = 0; $c < floor($total_answers/$quizCampaign->questions->count()); $c++)

        <?php
            $question_done = 0;
            $tr_done = false;
        ?>

        @foreach($search as $question_id => $answers)

            @if(isset($answers[$c]))
                
                @if ($loop->first)
                    <tr>
                @endif
                
                <td>{{ $answers[$c]->id }}</td>                
                    
                <?php
                    $question_done++;
                    $g++;
                ?>

                @if ($loop->last)
                    <?php
                        $tr_done = true;
                    ?>
                    </tr>
                @endif
                
            @endif

        @endforeach  

        @if(!$tr_done)
            </tr>
        @endif

        @if($question_done>0 && $question_done<$quizCampaign->questions->count())
            
            @for($c = 0; $c < $quizCampaign->questions->count()-$question_done; $c++)
                <tr><td></td></tr>
            @endfor
        @endif

    @endfor

    @for($c = 0; $c < $quizCampaign->questions->count(); $c++)
        
        @if($c==0)
          <tr>
        @endif
        <td>
            @if($c==0)
                ({{$g}}/{{$total_answers}})
            @endif
        </td>
        
        @if ($c == $quizCampaign->questions->count()-1)
          </tr>
        @endif
    @endfor
    </tbody>

</table>