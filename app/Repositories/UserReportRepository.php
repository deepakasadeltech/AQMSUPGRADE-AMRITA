<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\DoctorReport;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Counter;
use App\Models\Queue;
use App\Models\Call;
use Carbon\Carbon;
use DB;

class UserReportRepository
{
    public function getUsers()
    {
        return User::where('role', 'D')->orderBy('name', 'asc')
                    ->get();
    }

    public function getDoctorDetails()
    {
        return User::with('department','counter')->where('role', 'D')->get();
    }

   public function getDoctors()
    {
     return DoctorReport::get();
    }

    public function getCounters()
    {
        return Counter::all();
    }

    public function getQueuePatientDetails()
    {
        return Queue::where('called', 1)->get();
    }

    public function totalTokenIssued($sdate, $edate)
    {
        try {
            $sdate = Carbon::createFromFormat('d-m-Y', $sdate);
            $edate = Carbon::createFromFormat('d-m-Y', $edate);
            //$date = Carbon::createFromFormat('d-m-Y', $date);
        } catch(\Exception $e) {
            abort(404);
        }
        return Queue::where('called', 0)
                    ->whereBetween('created_at',[$sdate->format('Y-m-d 00:00:00'), $edate->format('Y-m-d 23:59:59')])
                    ->get();
    }

    public function totalTokenCalled($sdate, $edate)
    {
        try {
            $sdate = Carbon::createFromFormat('d-m-Y', $sdate);
            $edate = Carbon::createFromFormat('d-m-Y', $edate);
            //$date = Carbon::createFromFormat('d-m-Y', $date);
        } catch(\Exception $e) {
            abort(404);
        }
        return Queue::where('called', 1)
                    ->whereBetween('created_at',[$sdate->format('Y-m-d 00:00:00'), $edate->format('Y-m-d 23:59:59')])
                    ->get();
    }

//----------------showreport-page-------------------------------------
    public function doctorReportwithDateRange()
    {
     return User::with('department','counter')
                    ->where('role', 'D')
                    ->where('counter_id', '!=', NULL)
                    ->get();
    }

    public function getAvgCTimeEachDoctorWithDateRange($asdate, $aedate)
    {
        try {
            $asdate = Carbon::createFromFormat('d-m-Y', $asdate);
            $aedate = Carbon::createFromFormat('d-m-Y', $aedate);
            //$date = Carbon::createFromFormat('d-m-Y', $date);
        } catch(\Exception $e) {
            abort(404);
        }

        return Call::where('doctor_work_end', 1)
                   ->whereBetween('called_date',[$asdate->format('Y-m-d 00:00:00'), $aedate->format('Y-m-d 23:59:59')])
                   ->get();
    }

    public function gettokenMissedDoctorWithDateRange($asdate, $aedate)
    {
        try {
            $asdate = Carbon::createFromFormat('d-m-Y', $asdate);
            $aedate = Carbon::createFromFormat('d-m-Y', $aedate);
            //$date = Carbon::createFromFormat('d-m-Y', $date);
        } catch(\Exception $e) {
            abort(404);
        }

        return Call::where('doctor_work_start', 0)
                   ->whereBetween('called_date',[$asdate->format('Y-m-d 00:00:00'), $aedate->format('Y-m-d 23:59:59')])
                   ->get();
    }

    public function avgWaitingTimeofTokenForEachDepartment($asdate, $aedate)
    {
        try {
            $asdate = Carbon::createFromFormat('d-m-Y', $asdate);
            $aedate = Carbon::createFromFormat('d-m-Y', $aedate);
        } catch(\Exception $e) {
            abort(404);
        }
        return Queue::where('called', 1)
                    ->whereBetween('created_at',[$asdate->format('Y-m-d 00:00:00'), $aedate->format('Y-m-d 23:59:59')])
                    ->get();
    }

//---------------------------------------------------- 

    public function getAvgtimeAllDepartmentWise($sdate, $edate)
    {
        try {
            $sdate = Carbon::createFromFormat('d-m-Y', $sdate);
            $edate = Carbon::createFromFormat('d-m-Y', $edate);
            //$date = Carbon::createFromFormat('d-m-Y', $date);
        } catch(\Exception $e) {
            abort(404);
        }

        return Call::with('department')
                   ->where('doctor_work_end', 1)
                   ->whereBetween('called_date',[$sdate->format('Y-m-d 00:00:00'), $edate->format('Y-m-d 23:59:59')])
                   ->get();
    }

    public function getAvgtimeAllDepartmentWaiting($sdate, $edate)
    {
        try {
            $sdate = Carbon::createFromFormat('d-m-Y', $sdate);
            $edate = Carbon::createFromFormat('d-m-Y', $edate);
            //$date = Carbon::createFromFormat('d-m-Y', $date);
        } catch(\Exception $e) {
            abort(404);
        }

        return Queue::with('department')
                   ->where('called', 1)
                   ->whereBetween('created_at',[$sdate->format('Y-m-d 00:00:00'), $edate->format('Y-m-d 23:59:59')])
                   ->get();
    }



    public function getTokenWaitingTimes()
    {
        return Queue::where('called', 1)->get();
    }

    public function getCallTimes()
    {
        return Call::all();
    }

    public function getonedayDoctorAvgTime($id = '')
	{
		//$stat_day = date();
         return DoctorReport::whereBetween('start_time', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
         ->where('user_id', $id)->get();
    }
    
    public function getPatientSeenListDoctor()
	{   $uid = User::all();
       //$uid = $this->getUsers();
		$patientlist = DoctorReport::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('user_id', $uid)
        ->first();
        
        return $patientlist;
    }
      
    


    public function getUserReport(User $user, $sdate, $edate)
    {
        try {
            $sdate = Carbon::createFromFormat('d-m-Y', $sdate);
            $edate = Carbon::createFromFormat('d-m-Y', $edate);
            //$date = Carbon::createFromFormat('d-m-Y', $date);
        } catch(\Exception $e) {
            abort(404);
        }

       return $user->calls()
                    ->with('department', 'counter', 'queue')
                    ->whereBetween('called_date',[$sdate->format('Y-m-d 00:00:00'), $edate->format('Y-m-d 23:59:59')])
                    //->where('called_date', $date->format('Y-m-d'))
                    //->where('doctor_work_end', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    


}
