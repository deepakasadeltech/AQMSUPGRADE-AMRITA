<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentDepartment extends Model
{
	protected $fillable = ['name','olangname'];
	
	public function calls()
	{
		return $this->hasMany('App\Models\Call');
	}

     public function department()
	{
		return $this->belongsTo('App\Models\Department');
	}

    public function counter()
	{
		return $this->belongsTo('App\Models\Counter');
	}

	public function pdepartment()
	{
		return $this->belongsTo('App\Models\ParentDepartment');
	}

    
}
