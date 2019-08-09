<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CallRepository;
use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Counter;
use App\Models\Call;
use App\Models\UhidMaster;
use Carbon\Carbon;

class PatientCallController extends Controller
{
    protected $patientcalls;

    public function __construct(PatientCallRepository $patientcalls)
    {
        $this->patientcalls = $patientcalls;
    }

   
}
