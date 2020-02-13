<?php

namespace App\Domain\Sketch\Quiz\Model;

use App\Database\Eloquent\Model;

class SQuizQuestion extends Model
{
    public function s_options(){
      return $this->hasMany("App\Domain\Sketch\Quiz\Model\SQuizOption","s_quiz_question_id");
    }
    public function questions(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizQuestion","s_quiz_question_id");
    }
}
