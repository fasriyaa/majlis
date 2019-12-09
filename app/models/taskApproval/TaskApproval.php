<?php

namespace App\models\TaskApproval;

use Illuminate\Database\Eloquent\Model;

class TaskApproval extends Model
{
    protected $fillable = ['id', 'task_id', 'staff_id','user_id','comment','approval_status','status'];

    public function user()
    {
      return $this->belongsTo('App\User', 'staff_id');
    }
}
