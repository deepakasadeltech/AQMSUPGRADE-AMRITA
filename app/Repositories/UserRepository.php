<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Counter;
use App\Models\Limit;
use App\Models\Ad;


class UserRepository
{
    public function getCounter()
    {
        return Counter::all();
    }

    public function getAll()
    {
        return User::all();
    }

    public function getUserDoctorName()
    {
     return User::with('department', 'counter', 'ads') 
                   ->where('role', 'D')
                   ->get();
    }
    
    public function getAllUserName()
    { return User::with('department', 'counter') 
                   ->where('role', 'S')
                   ->get();
    }

    public function getAdminDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'A')
                   ->get();
    }

    public function getHelpdeskDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'H')
                   ->get();
    }

    public function getCmoDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'C')
                   ->get();
    }

    public function getDisplayCtrlDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'I')
                   ->get();
    }

    public function getPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function getDepartments()
    {
        return Department::all();
    }

   //-------------------Start-Superadmin-Details---------------------
       public function getadsAll(){
        return Ad::all();
       }

        public function No_Of_Doctor(){
            return User::where('role', 'D')->count();
        }

        public function No_Of_Staff(){
        return User::where('role', 'S')->count(); 
        }

        public function No_Of_Helpdesk(){
        return User::where('role', 'H')->count(); 
        }

        public function No_Of_CMO(){
        return User::where('role', 'C')->count(); 
        }

        public function No_Of_Displayctrl(){
        return User::where('role', 'I')->count(); 
        }

        public function getLimitData(){
            return Limit::first(); 
            }


//-------------------End-Superadmin-Details-----------------------


}
