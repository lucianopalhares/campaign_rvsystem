<?php

namespace App\Domain\Quiz\Model;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
      public function campaign(){
        return $this->belongsTo("App\Domain\Quiz\Model\QuizCampaign","quiz_campaign_id");
      }
      public function district(){
        return $this->belongsTo("App\Domain\City\Model\District","district_id");
      }
      public function answers(){
        return $this->hasMany("App\Domain\Quiz\Model\QuizAnswer","card_id");
      }
}
