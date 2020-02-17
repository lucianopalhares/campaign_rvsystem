<?php

namespace App\Domain\Quiz\Model;

use App\Database\Eloquent\Model;

class QuizOption extends Model
{
    public function campaign(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizCampaign","quiz_campaign_id");
    }
    public function question(){
      return $this->belongsTo("App\Domain\Quiz\Model\QuizQuestion","quiz_question_id");
    }
    public function answers(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","quiz_option_id");
    }
    public function quiz_optionable()
    {
        return $this->morphTo();
    }    
    public function getDescription(){
      $description = strlen($this->description)>0?$this->description:'';
      if($this->quiz_optionable_id){
        $description .= ' '.$this->quiz_optionable->nable();
      }
      return $description;
    }
}
