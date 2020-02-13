<?php

namespace App\Domain\Sketch\Quiz\Model;

use App\Database\Eloquent\Model;

class SQuizOption extends Model
{
    public function s_question(){
      return $this->belongsTo("App\Domain\Sketch\Quiz\Model\SQuizQuestion","s_quiz_question_id");
    }
    public function options(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizOption","s_quiz_option_id");
    }
}
