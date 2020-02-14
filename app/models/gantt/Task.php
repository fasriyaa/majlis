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

  public function piu()
  {
      return $this->belongsTo('App\models\piu\piu', 'piu_id', 'id');
  }

  public function children()
      {
          return $this->hasMany('App\models\gantt\Task','parent','id')->with('children');
      }

  public function comments()
    {
      return $this->hasMany('App\models\discussions\TaskDiscussions', 'task_id', 'id')->orderBy('updated_at','DESC');
    }



}
