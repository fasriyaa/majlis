<?php

namespace App\models\discussions;

use Illuminate\Database\Eloquent\Model;

class Snooz extends Model
{
    protected $fillable = ['id', 'discussion_id', 'task_id', 'discussion_cat_id', 'start_date', 'end_date'];
}
