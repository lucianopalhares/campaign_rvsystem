<?php

namespace App\Domain\Quiz\Model;

use App\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    public function campaign(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizCampaign","quiz_campaign_id");
    }
    public function answers(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","quiz_question_id");
    }
    public function options(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizOption","quiz_question_id");
    }
    public function quiz_questionable()
    {
        return $this->morphTo();
    }
}
