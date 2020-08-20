<?php

namespace App\Domain\City\Model;

use App\Database\Eloquent\Model;

class District extends Model
{
    public function city(){
      return $this->belongsTo("App\Domain\City\Model\City","city_id");
    }
<<<<<<< HEAD
    public function campaign(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizCampaign","quiz_campaign_id");
    }
=======
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    public function answers(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","district_id");
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
<<<<<<< HEAD
      $name = strlen($this->name)>0?$this->name.', ':'';
=======
      $name = strlen($this->name)>0?$this->name.', ':$this->type.', ';
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
      return $name.$this->city->title.'/'.$this->city->state->letter;
    }
}
