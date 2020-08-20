<?php

namespace App\Domain\City\Model;

use App\Database\Eloquent\Model;

class City extends Model
{    
    public function state(){
      return $this->belongsTo("App\Domain\City\Model\State","state_id");
    }
    public function answers(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","city_id");
    }
    public function disctricts(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","city_id");
    }
<<<<<<< HEAD
    public function campaigns(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizCampaign","city_id");
    }
=======
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    public function questions()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizQuestion', 'quiz_questionable');
    }
    public function options()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizOption', 'quiz_optionable');
    }
    public function nable(){
      return $this->title.'/'.$this->state->letter;
    }
}
