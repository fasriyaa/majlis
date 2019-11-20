<?php

namespace App\models\modules;

use Illuminate\Database\Eloquent\Model;

class MainModules extends Model
{
    protected $fillable = ['id', 'name', 'order','status'];
}
