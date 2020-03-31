<?php

namespace App\models\budget;

use Illuminate\Database\Eloquent\Model;

class PV extends Model
{
    //


    public function invoice()
    {
      return $this->belongsTo('App\models\budget\Invoice', 'id','pv_id');
    }
}
