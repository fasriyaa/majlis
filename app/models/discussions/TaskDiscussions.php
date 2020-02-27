<?php

namespace App\models\discussions;

use Illuminate\Database\Eloquent\Model;

class TaskDiscussions extends Model
{
    protected $fillable = ['id', 'discussion_id', 'task_id', 'progress','last_due', 'comment', 'next_step', 'status'];

    public function task()
    {
      return $this->belongsTo('App\models\gantt\Task', 'task_id');
    }


}
