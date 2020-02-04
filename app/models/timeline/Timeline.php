<?php

namespace App\models\timeline;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = ['id', 'text', 'task','user','type','url'];

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function task()
    {
      return $this->belongsTo('App\models\gantt\Task', 'task_id');
    }
}
