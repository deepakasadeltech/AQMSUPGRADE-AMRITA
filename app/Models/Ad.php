<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = ['name','adimg'];

    public function calls()
	{
		return $this->hasMany('App\Models\Call');
	}

	public function ad()
	{
		return $this->belongsTo('App\Models\Ad');
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
