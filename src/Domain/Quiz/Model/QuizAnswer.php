<?php

namespace App\Domain\Quiz\Model;

use App\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    public function question(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizQuestion","quiz_question_id");
    }
    public function campaign(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizCampaign","quiz_campaign_id");
    }
    public function option(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizOption","quiz_option_id");
    }
    public function option2(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizOption","quiz_option_id2");
    }
    public function option3(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizOption","quiz_option_id3");
    }
}
