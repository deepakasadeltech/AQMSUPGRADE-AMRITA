<?php

namespace App\Repositories;

use App\Models\Language;
use App\Models\Setting;
use App\Models\Queue;
use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Counter;


class SettingsRepository
{
    public function getLanguages()
    {
        return Language::all();
    }

    public function getSettings()
    {
        return Setting::first();
    }
	
	public function getUsers()
    {
        return User::all();
    }

    public function getCounters()
    {
        return Counter::all();
    }
	
	public function getPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function getDepartments()
    {
        return Department::all();
    }

    public function getSingleUsers($id)
    {
        return User::all()->where('id', $id);
    }
   
    public function getSinglePDepartments($id)
    {
        return ParentDepartment::all()->where('id', $id);
    }

    public function getSingleDepartments($id)
    {
        return Department::all()->where('id', $id);
    }

    public function getCountersByPid($uid = '', $pdepid = '', $depid = '', $counter_id = '')
    {
        $couters = User::all();
        $counter_ids = [];
        foreach($couters as $couter){
            if(!empty($couter->counter_id) && $couter->counter_id != $counter_id)
            {

                $counter_ids[] = $couter->counter_id;
            }
           
        }
       
        $counter_ids = array_filter($counter_ids);
        if(!empty($counter_ids)){
            return Counter::whereNotIn('id', $counter_ids)->where('pid', $pdepid)->where('department_id', $depid)->get();
        }else{
            return Counter::all()->where('pid', $pdepid)->where('department_id', $depid);
        }
       
        
    }

//---------------------------------------------

public function getTotalUsercounter($counter_id = '', $department_id = '', $pid = '')
    {
        return Counter::whereIn('id', $counter_id)
                       ->where('department_id', $department_id)
                       ->where('pid', $pid)
                       ->get();
    }

//---------------------------------------------

}
