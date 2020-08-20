<?php

namespace App\Domain\Political\Model;

use App\Database\Eloquent\Model;

class Politic extends Model
{
    public function person(){
      return $this->belongsTo("App\Domain\Person\Model\Person","person_id");
    }
    public function office(){
      return $this->belongsTo("App\Domain\Political\Model\PoliticalOffice","political_office_id");
    }
    public function party(){
      return $this->belongsTo("App\Domain\Political\Model\PoliticalParty","political_party_id");
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
      return $this->person->getFullNameAttribute();
    }
}
