<?php

namespace App\Domain\City\Model;

use App\Database\Eloquent\Model;

class State extends Model
{    
    public function cities(){
      return $this->hasMany("App\Domain\City\Model\City","state_id");
    }
    public function questions()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizQuestion', 'quiz_questionable');
    }
    public function campaigns(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizCampaign","state_id");
    }
    public function options()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizOption', 'quiz_optionable');
    }
    public function nable(){
      return $this->title;
    }
}
