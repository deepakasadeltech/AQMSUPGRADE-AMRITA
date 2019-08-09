<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = ['name','display_sequence','pid','department_id'];

    public function calls()
	{
		return $this->hasMany('App\Models\Call');
	}

	public function counter()
	{
		return $this->belongsTo('App\Models\Counter');
	}

	public function department()
	{
		return $this->belongsTo('App\Models\Department');
	}

	public function pdepartment()
	{
		return $this->belongsTo('App\Models\ParentDepartment');
	}

	

	


}
