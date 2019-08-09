<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'olangname', 'regcode', 'letter', 'start', 'pid', 'is_uhid_required'];

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
