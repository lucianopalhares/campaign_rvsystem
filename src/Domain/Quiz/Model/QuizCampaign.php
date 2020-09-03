<?php

namespace App\Domain\Quiz\Model;

use App\Database\Eloquent\Model;

class QuizCampaign extends Model
{
    public function state(){
      return $this->belongsTo("App\Domain\City\Model\State","state_id");
    }
    public function city(){
      return $this->belongsTo("App\Domain\City\Model\City","city_id");
    }
    public function districts(){
      return $this->hasMany("App\Domain\City\Model\District","quiz_campaign_id");
    }
    public function questions(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizQuestion","quiz_campaign_id");
    }
    public function options(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizOption","quiz_campaign_id");
    }
    public function answers(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","quiz_campaign_id");
    }

    public function answersDescriptions(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","quiz_campaign_id")->select(['description','quiz_question_id']);
    }
}
