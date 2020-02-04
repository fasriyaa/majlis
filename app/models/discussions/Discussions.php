<?php

namespace App\models\discussions;

use Illuminate\Database\Eloquent\Model;

class Discussions extends Model
{
    protected $fillable = ['id', 'type', 'status'];

    public function piu()
    {
      return $this->belongsTo('App\models\piu\piu', 'piu_id', 'id');
    }
}
