<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['call_id', 'pid', 'department_id', 'user_id', 'counter_id', 'number', 'pname', 'pmobile', 'pemail', 'revnumber', 'last_seen_by', 'last_seen_date'];

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

	public function queue()
	{
		return $this->hasMany('App\Models\Queue');
	}
   
	public function doctorreport()
	{
		return $this->belongsTo('App\Models\DoctorReport');
	}

	public function getDoctorName()
	{
		return $this->belongsTo('App\Models\User');
    }
    
    public function queues()
	{
		return $this->hasMany('App\Models\Queue');
	}

	public function reviews()
	{
		return $this->hasMany('App\Models\Review');
	}

    public function calls()
	{
		return $this->hasMany('App\Models\Call');
	}

}
