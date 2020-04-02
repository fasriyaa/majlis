<?php

namespace App\models\budget;

use Illuminate\Database\Eloquent\Model;

class TimeBaseActual extends Model
{

    public function invoice()
      {
          return $this->belongsTo('App\models\budget\Invoice', 'invoice_id','id');
      }
}
