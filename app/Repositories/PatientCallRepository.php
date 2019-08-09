<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\Call;
use Carbon\Carbon;
use App\Models\ParentDepartment;

class PatientCallRepository
{
    public function getSettings()
    {
        return Setting::first();
    }

    public function patientcalls()
    {
        return PatientCall::all();
    }

    
}
