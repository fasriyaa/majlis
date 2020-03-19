<?php

namespace App\models\discussions;

use Illuminate\Database\Eloquent\Model;

class DiscussionAgenda extends Model
{
    protected $fillable = ['description', 'discussion_id', 'submitter_type','submitter_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'staff', 'id');
    }

    public function piu()
    {
        return $this->belongsTo('App\models\piu\piu', 'piu_id', 'id');
    }
}
