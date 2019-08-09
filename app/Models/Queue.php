<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['pid', 'department_id', 'user_id', 'counter_id', 'number', 'pname', 'pmobile', 'pemail', 'regnumber', 'refer_by', 'token_type', 'called', 'uhid', 'priority', 'customer_waiting'];

    public function call()
	{
		return $this->hasOne('App\Models\Call');
	}

    public function department()
	{
		return $this->belongsTo('App\Models\Department');
	}
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
	public function counter()
	{
		return $this->belongsTo('App\Models\Counter');
	}
   
	public function doctorreport()
	{
		return $this->belongsTo('App\Models\DoctorReport');
	}

	public function getDoctorName()
	{
		return $this->belongsTo('App\Models\User');
	}

}
