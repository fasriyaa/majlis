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

    public function child()
        {
            return $this->hasMany('App\models\gantt\Task','parent','id');
        }
  public function parent()
      {
          return $this->belongsTo('App\models\gantt\Task','parent_id','id')->with('piu');
      }

  public function comments()
    {
      return $this->hasMany('App\models\discussions\TaskDiscussions', 'task_id', 'id')->orderBy('updated_at','DESC');
    }

  public function allocations()
  {
    return $this->belongsTo('App\models\budget\Allocation','id','task_id');
  }

  public function child_allocations()
      {
          return $this->hasMany('App\models\gantt\Task','parent','id')->with('allocations');
      }

  public function budget()
  {
    return $this->belongsTo('App\models\budget\budget','id','task_id');
  }

  public function child_budget()
      {
          return $this->hasMany('App\models\gantt\Task','parent','id')->with('budget');
      }

  public function contracts()
      {
          return $this->hasMany('App\models\procurement\contracts','task_id');
      }


}
