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
}
