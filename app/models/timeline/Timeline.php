<?php

namespace App\models\timeline;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = ['id', 'text', 'task','user'];
}
