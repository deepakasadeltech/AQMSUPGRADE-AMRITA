<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\Call;
use App\Models\User;
use App\Models\Department;
use App\Models\Counter;
use App\Models\UhidMaster;
use Carbon\Carbon;
use App\Models\ParentDepartment;

class DoctorReportRepository
{
    public function getSettings()
    {
        return Setting::first();
    }

    public function doctorreports()
    {
        return DoctorReport::all();
    }

   

    
}
