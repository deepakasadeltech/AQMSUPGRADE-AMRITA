<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    protected $fillable = ['doctor', 'user', 'cmo', 'displayctrl', 'helpdesk', 'department', 'pdepartment', 'room', 'ads', 'tokenperday'];

   
}
