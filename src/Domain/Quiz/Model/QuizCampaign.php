<?php

namespace App\Domain\Quiz\Model;

use App\Database\Eloquent\Model;

class QuizCampaign extends Model
{
    public function questions(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizQuestion","quiz_campaign_id");
    }
    public function answers(){
      return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","quiz_campaign_id");
    }
}
