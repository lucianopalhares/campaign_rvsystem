<?php

namespace App\Domain\City\Model;

use App\Database\Eloquent\Model;

class District extends Model
{
    public function city(){
      return $this->belongsTo("App\Domain\City\Model\City","city_id");
    }
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
}
