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
    public function state(){
      return $this->belongsTo("App\Domain\City\Model\State","state_id");
    }
    public function city(){
      return $this->belongsTo("App\Domain\City\Model\City","city_id");
    }
    public function district(){
      return $this->belongsTo("App\Domain\City\Model\District","district_id");
    }
    public function card(){
      return $this->belongsTo("App\Domain\Quiz\Model\Card","card_id");
    }
}
