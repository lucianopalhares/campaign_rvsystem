<?php

namespace App\Domain\Person\Model;

use App\Database\Eloquent\Model;

class Person extends Model
{
    public function politic(){
      return $this->hasOne("App\Domain\Political\Model\Politic","person_id");
    }
    public function user(){
      return $this->belongsTo("App\Domain\Account\Model\User","user_id");
    }
    public function questions()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizQuestion', 'quiz_questionable');
    }
    public function options()
    {
        return $this->morphMany('App\Domain\Quiz\Model\QuizOption', 'quiz_optionable');
    }
    public function getFullNameAttribute(){
      $name = $this->first_name;
      $this->last_name?$name.=' '.$this->last_name:'';
      return $name;
    }
    public function nable(){
      return $this->getFullNameAttribute();
    }
}
