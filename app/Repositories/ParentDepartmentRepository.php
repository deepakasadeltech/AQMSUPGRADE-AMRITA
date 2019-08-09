<?php

namespace App\Repositories;

use App\Models\ParentDepartment;
use App\Models\Limit;

class ParentDepartmentRepository
{
    public function getAll()
    {
        return ParentDepartment::all();
    }

    //-------------------Start-Superadmin-Details---------------------
    public function No_Of_Pdepartment(){
        return ParentDepartment::count();
    }

    public function getLimitData(){
        return Limit::first(); 
        }
//-------------------End-Superadmin-Details-----------------------

}
