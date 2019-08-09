<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserReportRepository;
use App\Models\User;
use App\Models\DoctorReport;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Counter;
use App\Models\Queue;
use App\Models\Call;

class UserReportController extends Controller
{
  protected $user_reports;

    public function __construct(UserReportRepository $user_reports)
    {
        $this->user_reports = $user_reports;
    }

    public function index(Request $request)
    {
        $this->authorize('access', User::class);

        return view('user.reports.user.index', [
            'users' => $this->user_reports->getUsers(),
            'doctors' => $this->user_reports->getDoctors(),
            'counters' => $this->user_reports->getCounters(),
            //'getAvgtimeDepartmentWise' => $this->user_reports->getAvgtimeDepartmentWise(),
            'doctordetails' => $this->user_reports->getDoctorDetails(),
            'tokenwaitingtimes' => $this->user_reports->getTokenWaitingTimes(),
            'calltimes' => $this->user_reports->getCallTimes(),
            'daily_avgtime_of_doctor' =>$this->user_reports->getPatientSeenListDoctor(),
            'queue_patient_details' =>$this->user_reports->getQueuePatientDetails(),
           // 'totalTokenIssued' =>$this->user_reports->totalTokenIssued(),
           
        ]);
    }

    public function show(Request $request, User $user, $sdate, $edate)
    {
        $this->authorize('access', User::class);

        return view('user.reports.user.show', [
            'calls' => $this->user_reports->getUserReport($user, $sdate, $edate),
            'suser' => $user,
            //'date' => $date,
            'sdate' => $sdate,
            'edate' => $edate,
            'users' => $this->user_reports->getUsers(),
            'doctors' => $this->user_reports->getDoctors(),
            'counters' => $this->user_reports->getCounters(),
            'getAvgtimeAllDepartmentWise' => $this->user_reports->getAvgtimeAllDepartmentWise($sdate, $edate),
            'doctordetails' => $this->user_reports->getDoctorDetails(),
            'tokenwaitingtimes' => $this->user_reports->getTokenWaitingTimes(),
            'calltimes' => $this->user_reports->getCallTimes(),
            'patient_seen' => $this->user_reports->getonedayDoctorAvgTime(),
            'daily_avgtime_of_doctor' => $this->user_reports->getPatientSeenListDoctor(),
            'queue_patient_details' => $this->user_reports->getQueuePatientDetails(),
            'totalTokenIssued' => $this->user_reports->totalTokenIssued($sdate, $edate),
            'totalTokenCalled' => $this->user_reports->totalTokenCalled($sdate, $edate),
            'getAvgtimeAllDepartmentWaiting' => $this->user_reports->getAvgtimeAllDepartmentWaiting($sdate, $edate),
            
        ]);

    }
//----------------------------------    

public function showrecord(Request $request, $asdate, $aedate)
    {     
        $this->authorize('access', User::class);
 
        return view('user.reports.user.showrecord', [
            'counters' => $this->user_reports->getCounters(),
            //'date' => $date,
            'asdate' => $asdate,
            'aedate' => $aedate,
            'doctorReportwithDateRange' => $this->user_reports->doctorReportwithDateRange(),
            'getAvgCTimeEachDoctorWithDateRange' => $this->user_reports->getAvgCTimeEachDoctorWithDateRange($asdate, $aedate),
            'avgWaitingTimeofTokenForEachDepartment' => $this->user_reports->avgWaitingTimeofTokenForEachDepartment($asdate, $aedate),
            'gettokenMissedDoctorWithDateRange' => $this->user_reports->gettokenMissedDoctorWithDateRange($asdate, $aedate),
            
            
        ]);

    }




//-----------------------------------




}
