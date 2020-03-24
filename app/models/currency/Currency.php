<?php

namespace App\models\currency;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['code', 'name','xrate','status'];
}
