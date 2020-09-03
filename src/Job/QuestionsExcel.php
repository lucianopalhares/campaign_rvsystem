<?php

namespace App\Job;

use App\Domain\Quiz\Model\QuizQuestion;
use App\Domain\Quiz\Model\QuizCampaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class QuestionsExcel implements FromView
{
    public $quizCampaign;
    /*public function collection()
    {
        return QuizQuestion::all();
    }

    /**
     * @var QuizQuestion $question
     * @return array
     */
    /*public function map($question): array
    {
       
        return [
            $question->id,
            '=A2+1',
            $question->description,
            $question->quiz_id,
            $question->quiz_id,
        ];
    }*/
    public function __construct(QuizCampaign $quizCampaign){
        $this->quizCampaign = $quizCampaign;
    }
    public function view(): View
    {
        
        return view('app.quiz.question.excel', [
            'quizCampaign' => $this->quizCampaign
        ]);
    }
}