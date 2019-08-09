<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $fillable = ['queue_id', 'pid', 'department_id', 'counter_id', 'user_id', 'number', 'called_date'];

   
}
