<?php

namespace App\models\budget;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //

    public function contract()
    {
      return $this->belongsTo('App\models\procurement\contracts', 'contract_id', 'id');
    }

    public function timeline()
    {
        return $this->hasMany('App\models\timeline\Timeline','record_id');
    }

    public function matrix()
    {
      return $this->belongsTo('App\models\auth\ApprovalMatrix', 'id','model_id');
    }
}
