<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorReport extends Model
{
    protected $fillable = ['call_id', 'department_id', 'pid', 'user_id'];

    public function queue()
	{
		return $this->belongsTo('App\Models\Queue');
	}

    public function department()
	{
		return $this->belongsTo('App\Models\Department');
	}

	public function pdepartment()
	{
		return $this->belongsTo('App\Models\ParentDepartment');
	}

    public function counter()
	{
		return $this->belongsTo('App\Models\Counter');
	}

    public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

}
