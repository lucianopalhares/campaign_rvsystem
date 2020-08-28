<?php

namespace App\Domain\City\Model;

use App\Database\Eloquent\Model;

class District extends Model
{
    public function city(){
      return $this->belongsTo("App\Domain\City\Model\City","city_id");
    }
    public function campaign(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizCampaign","quiz_campaign_id");
    }
    public function answers(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","district_id");
    }
    public function answersCampaign($quiz_campaign_id){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","district_id")->where('quiz_answers.quiz_campaign_id', '=', $quiz_campaign_id);
    }    
    public function questions()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizQuestion', 'quiz_questionable');
    }
    public function options()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizOption', 'quiz_optionable');
    }
    public function nable(){
      $name = strlen($this->name)>0?$this->name.', ':'';
      return $name.$this->city->title.'/'.$this->city->state->letter;
    }
}
