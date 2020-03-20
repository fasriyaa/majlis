<?php

namespace App\models\budget;

use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    protected $fillable = ['task_id', 'base_allocation'];
}
