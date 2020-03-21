<?php

namespace App\models\budget;

use Illuminate\Database\Eloquent\Model;

class budget extends Model
{
    protected $fillable = ['task_id', 'budget','status'];
}
