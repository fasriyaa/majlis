<?php

namespace App\models\gantt;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $appends = ["open"];

  public function getOpenAttribute(){
      return true;
  }

  public function user()
  {
      return $this->belongsTo('App\User', 'staff', 'id');
  }


}
