<?php

namespace App\models\procurement;

use Illuminate\Database\Eloquent\Model;

class contracts extends Model
{
    protected $fillable = ['type', 'contract_no', 'task_id','currency','amount','contractor','date','duration','status'];

    public function type()
    {
      return $this->belongsTo('App\models\procurement\ContractTypes', 'type_id', 'id');
    }

    public function task()
    {
      return $this->belongsTo('App\models\gantt\Task','task_id');
    }

    public function currency()
    {
      return $this->belongsTo('App\models\currency\Currency','currency_id');
    }
}
