<?php

namespace App\models\procurement;

use Illuminate\Database\Eloquent\Model;

class Variations extends Model
{
    //


    public function timeline()
    {
        return $this->hasMany('App\models\timeline\Timeline','record_id');
    }

    public function contract()
    {
        return $this->belongsTo('App\models\procurement\contracts','contract_id');
    }
}
