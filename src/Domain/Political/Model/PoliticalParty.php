<?php

namespace App\Domain\Political\Model;

use App\Database\Eloquent\Model;

class PoliticalParty extends Model
{
    public function politics(){
      return $this->hasMany("App\Domain\Political\Model\Politic","political_party_id");
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
      return $this->name;
    }
}
