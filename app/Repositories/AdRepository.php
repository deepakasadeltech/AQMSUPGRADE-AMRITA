<?php

namespace App\Repositories;

use App\Models\Counter;
use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Limit;
use App\Models\Ad;

class AdRepository
{
    public function getAll()
    {
        return Ad::all();
    }
    
    public function getPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function getDepartments()
    {
        return Department::all();
    }

    public function getAdimg($id = '')
    {
        return Ad::where('id','=', $id)->get();
    }

    public function getcounterMapDetails()
    {
        return Counter::with('department','pdepartment') 
                        //->where('department', 'department.id','=','counter.department_id')
                       ->get();
    }

     //-------------------Start-Superadmin-Details---------------------
     public function No_Of_Ads(){
        return Ad::count();
    }

    public function getLimitData(){
        return Limit::first(); 
        }
//-------------------End-Superadmin-Details-----------------------


}
