<?php

namespace App\models\meetings;

use Illuminate\Database\Eloquent\Model;

class Meetings extends Model
{
    public function member()
    {
      return $this->belongsTo('App\models\members\Members', 'member_id', 'id');
    }

    public function participants()
    {
      return $this->hasMany('App\models\meetings\Participants', 'meeting_id', 'id');
    }
}
