<?php

namespace App\models\timeline;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id','id');
    }
}
