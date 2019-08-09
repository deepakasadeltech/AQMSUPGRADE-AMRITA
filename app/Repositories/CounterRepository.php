<?php

namespace App\Repositories;

use App\Models\Counter;
use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Limit;

class CounterRepository
{
    public function getAll()
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

    public function getcounterMapDetails()
    {
        return Counter::with('department','pdepartment') 
                        //->where('department', 'department.id','=','counter.department_id')
                       ->get();
    }

     //-------------------Start-Superadmin-Details---------------------
     public function No_Of_Counter(){
        return Counter::count();
    }

    public function getLimitData(){
        return Limit::first(); 
        }
//-------------------End-Superadmin-Details-----------------------


}
