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
<<<<<<< HEAD
    public function campaigns(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizCampaign","state_id");
    }
=======
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    public function options()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizOption', 'quiz_optionable');
    }
    public function nable(){
      return $this->title;
    }
}
