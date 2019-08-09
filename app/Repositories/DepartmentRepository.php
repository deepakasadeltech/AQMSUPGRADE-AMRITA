<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Limit;

class DepartmentRepository
{
    public function getAll()
    {
        return Department::all();
    }
    //-------------------Start-Superadmin-Details---------------------
     public function No_Of_Department(){
        return Department::count();
    }

    public function getLimitData(){
        return Limit::first(); 
        }
//-------------------End-Superadmin-Details-----------------------


}
