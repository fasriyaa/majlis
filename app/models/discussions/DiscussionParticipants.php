<?php

namespace App\models\discussions;

use Illuminate\Database\Eloquent\Model;

class DiscussionParticipants extends Model
{
    protected $fillable = ['discussion_id', 'user_id'];

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }
}
