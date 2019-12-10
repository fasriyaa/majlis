<?php

namespace App\models\docs;

use Illuminate\Database\Eloquent\Model;

class RequireDoc extends Model
{
    protected $fillable = ['id', 'task_id','doc_name','status'];

    public function task()
    {
        return $this->belongsTo('App\models\gantt\Task', 'task_id', 'id');
    }
}
