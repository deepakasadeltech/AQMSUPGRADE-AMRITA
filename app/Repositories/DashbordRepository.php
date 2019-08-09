<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Setting;
use App\Models\Queue;
use App\Models\Call;
use App\Models\Counter;
use App\Models\Department;
use App\Models\ParentDepartment;
use Carbon\Carbon;
use App\Models\DoctorReport;
use App\Models\QueueSetting;
use App\Models\Ad;


class DashbordRepository
{  
    public function getDoctorRoomInQueue()
    {
        return Queue::all();
    }

    public function getCounter()
    {
        return Counter::all();
    }
    
    public function getSetting()
    {
        return Setting::first();
    }

    public function getQueueSetting()
    {
        return QueueSetting::first();
    }

    public function getTodayQueue()
    {
        return Queue::with('call')->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->get();

    }

    public function getTodayAvgWaitingTime()
    {
        return Queue::with('call')->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('called', 1)
                    ->get();

    }

    public function getTodaytpatienttoDoctor()
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->get();

    }

    public function getTodayAvgConsultingTime()
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('doctor_work_end', 1)->where('doctor_work_start', 1)
                    ->get();

    }

    public function getTodayServed()
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->count();
    }

    public function getCounters()
    {
        return Counter::all();
    }

    public function getTodayMissed()
    {
        $setting = $this->getSetting();

        $calls = Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->get();

        $count = 0;
        foreach ($calls as $call) {
            $next_call_key = $calls->search(function($incall, $key) use($call) {
                if(($incall->id>$call->id) && ($incall->counter_id==$call->counter_id)) return $key;
            });

            if($next_call_key && ($calls[$next_call_key]->created_at->timestamp-$call->created_at->timestamp)<$setting->missed_time) $count++;
        }
        return $count;
    }

    public function getTodayOverTime()
    {
        $setting = $this->getSetting();

        $calls = Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->get();

        $count = 0;
        foreach ($calls as $call) {
            $next_call_key = $calls->search(function($incall, $key) use($call) {
                if(($incall->id>$call->id) && ($incall->counter_id==$call->counter_id)) return $incall;
            });

            if($next_call_key && ($calls[$next_call_key]->created_at->timestamp-$call->created_at->timestamp)>$setting->over_time) $count++;
        }
        return $count;
    }

    public function getTodayCalls()
    {
        $counters = $this->getCounters();

        $count = [];
        foreach ($counters as $counter) {
            $count[] = $counter->calls()
                    ->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->count();
        }

        return $count;
    }

    public function getYesterdayCalls()
    {
        $counters = $this->getCounters();

        $count = [];
        foreach ($counters as $counter) {
            $count[] = $counter->calls()
                    ->whereBetween('created_at', [Carbon::yesterday()->format('Y-m-d').' 00:00:00', Carbon::yesterday()->format('Y-m-d').' 23:59:59'])
                    ->count();
        }

        return $count;
    }

    public function updateNotification($data)
    {
        $setting = $this->getSetting();

        $setting->notification = $data['notification'];
        $setting->size = $data['size'];
        $setting->color = $data['color'];
        $setting->save();

        return $setting;
    }
	
	public function getPatientList($pid = '', $department_id = '')
	{
		$calls = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('pid', $pid)
		->where('department_id', $department_id)
		->where('doctor_work_end', 0)
		->orderBy('id', 'desc')
		->take(3)
		->get();
		
		return $calls;
    }
    
    public function getPatientListDoctorWise($id = '', $department_id = '')
	{
		$calls = Call::with('queue', 'department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('user_id', $id)
		->where('department_id', $department_id)
		->where('doctor_work_end', 0)
		->orderBy('id', 'desc')
		->take(6)
		->get();
		
		return $calls;
	}
	
	public function getPatientSeenList($id = '')
	{
		$calls = DoctorReport::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('user_id', $id)
		->count();
		
		return $calls;
    }
//-----------------------------------------------
    public function getDailyDoctorAvgTime($id = '')
	{
		//$stat_day = date();
         return DoctorReport::whereBetween('start_time', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
         ->where('user_id', $id)->get();
    }

    public function getTodayQueueByCounter($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)
                    ->where('department_id', $department_id)
		            ->get();

    }
    
    public function getTodayPalatinump($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('priority', 1)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodayGoldp($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('priority', 2)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodaySilverp($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('priority', 3)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodayPatientCalledByCounter($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 1)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodayPatientCalledByDoctor($id = '')
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('user_id', $id)
		            ->get();
		            

    }

    public function getUserDetails($pid = '', $department_id = '', $counter_id = ''){
        
        $calls = User::with('department', 'counter') 
        ->where('pid', $pid)
		->where('department_id', $department_id)
        ->where('counter_id', $counter_id)
        ->first();
    
        return $calls;
    }

    public function getUserDoctor()
    {
        return User::with('department', 'counter') 
                   ->where('role', 'D')
                   ->get();
    }

    public function getUserStaff(){
        return User::where('role', 'S')->get(); 
    }

    public function gettotalDoctorPresent()
    {
        return User::where('user_status', '1')->where('role', 'D')
                   ->get();
    }

    public function gettotalDoctorAbsent()
    {
        return User::where('user_status', '2')->where('role', 'D')
                   ->get();
    }

 //-------------------------------------------------------   
 public function getAllDepartmentTotalQueueInToday()
 {     
     return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
     //->where('called', 0)
     ->get();

 }
 public function getAllDepartmentTotalCalledInToday()
 {
     return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('doctor_work_end', 1)->get();

 }

 public function getAllDepartmentStartWorkbutNotEndToday()
 {
     return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('doctor_work_start', 0)->get();

 }

 public function getAllDepartmentTotalCalledbutNotSeenToday()
 {
     return Call::with('department','queue')->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
     //->where('doctor_work_start', 1)
     ->where('doctor_work_end', 0)
     ->get();

 }

 public function getAllDepartmentTotalpendingTokenForCallToday()
 {
     return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
     ->where('called', 0)
     ->get();

 }

  //-----------------------------------------------
  
    public function getPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function getPDepartmentName($id)
	{
		return ParentDepartment::find($id);
	}
	
	public function getDepartments()
    {
        return Department::all();
    }

    

    public function getNextToken(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->first();
    }

    public function getNextTokenByPriority(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('priority', 'asc')
					->take(1)
					->get();
					//->first();
    }

//------------Doctor-wise-token-function----------------    
    public function getNextTokenByPriorityDoctor(Department $department, $user_id)
    {  $rooms_id = Auth::user()->counter_id;
        $array_rooms_id =  explode(', ', $rooms_id); 
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->where('user_id', $user_id)
                    ->whereIn('counter_id', $array_rooms_id)
                    ->orderBy('priority', 'asc')
					->take(1)
					->get();
					//->first();
    }

public function getTodayQueueByCounterDoctor($department_id = '', $user_id = '')
    {   
           $rooms_id = Auth::user()->counter_id;
            $array_rooms_id =  explode(', ', $rooms_id); 
            
        
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)
                    ->where('department_id', $department_id)
                    ->where('user_id', $user_id)
                    ->whereIn('counter_id', $array_rooms_id)
		            ->get();

    }

    public function getTodayPalatinumpDoctor($department_id = '', $id = '')
    {  
        $rooms_id = Auth::user()->counter_id;
            $array_rooms_id =  explode(', ', $rooms_id); 
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('priority', 1)
                    ->where('department_id', $department_id)
                    ->where('user_id', $id)
                    ->whereIn('counter_id', $array_rooms_id)
		            ->get();

    }

    public function getTodayGoldpDoctor($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('priority', 2)
                    ->where('department_id', $department_id)
                    //->where('user_id', $user_id)
                    //->where('counter_id', $counter_id)
		            ->get();

    }

    public function getTodaySilverpDoctor($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('priority', 3)
                    ->where('department_id', $department_id)
                    //->where('user_id', $user_id)
                    //->where('counter_id', $counter_id)
		            ->get();

    }
//-------------------Start-Superadmin-Details---------------------
                public function No_Of_Doctor(){
                     return User::with('department', 'counter')->where('role', 'D')->get();
                }

                public function No_Of_Staff(){
                    return User::where('role', 'S')->get(); 
                }

                public function No_Of_Helpdesk(){
                    return User::where('role', 'H')->get(); 
                }

                public function No_Of_CMO(){
                    return User::where('role', 'C')->get(); 
                }

                public function No_Of_Displayctrl(){
                    return User::where('role', 'I')->get(); 
                }

                public function No_Of_Pdepartment(){
		           return ParentDepartment::all();
	            }
	
	            public function No_of_Department(){
                   return Department::all();
                }

                public function No_of_Counter(){
                    return Counter::all();
                 }

                public function No_of_tokenPerDay(){
                    return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->get();
                 } 

                 public function No_of_Ads(){
                    return Ad::all();
                 }
//-------------------End-Superadmin-Details-----------------------

                public function activeDoctorToseeRefererral(){
                    $doctor = User::with('counter','department')
                    ->where('user_status', 1)
                    ->where('role', 'D')
                    ->where('pid', '!=', NULL)
                    ->where('counter_id', '!=', NULL)
                    ->where('department_id', '!=', Auth::user()->department_id)
                    ->where('id', '!=', Auth::user()->id)
                    ->get();
                    return $doctor;

                    }
//---------------------------------------------------------

    public function getLastToken(Department $department)
    {
        return $department->queues()
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('number', 'desc')
                    ->first();
    }

    public function getLastTokenDoctor(Department $department)
    {
        return $department->queues()
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('number', 'desc')
                    ->first();
    }

    public function getRegistNumber($rigistnum)
    {
                return Queue::where('regnumber', $rigistnum)
                //->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                ->count();          
    }

    public function getCustomersWaiting(Department $department, $priority)
    {
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->where('priority', $priority)
                    ->count();
    }

    public function getCustomersWaitingAfterModify(Department $department, $priority)
    {
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->where('priority', $priority)
                    ->count();
    }
	
	public function isTokenExist($pid, $department_id, $token)
    {
        return Queue::where('pid', $pid)
                    ->where('department_id', $department_id)
					->where('number', $token)
					->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->count();
    }


    public function getActiveDepartmentsToseeReferral()
    {
        $depid = User::all()->where('user_status', '1')
                  ->where('counter_id', '!=', NULL)
                  ->where('department_id', '!=', Auth::user()->department_id)
                  ->where('role', 'D');
       
        $ids = [];
        foreach($depid as $id){
            if(!empty($id->department_id)){
                $ids[$id->department_id] = $id->department_id;
            }
        }
        return Department::whereIn('id', $ids)->get();
    }


    public function activeDoctorDispensary(){
        $kiosksett = QueueSetting::first();
        $doctor = User::with('counter','department')
        ->where('user_status', 1)
        ->where('role', 'D')
        ->where('pid', '!=', NULL)
        ->where('counter_id', '!=', NULL)
        ->where('department_id', '!=', Auth::user()->department_id)
        ->where('department_id',  $kiosksett->dispensary_id)
        ->where('id', '!=', Auth::user()->id)
        ->get();
        return $doctor;

        }


        public function getLastRoomNumber(Department $department, $pid='', $doctor_id = '', $counter_id = '')
        {
        return Call::where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
        ->where('pid', $pid)
        ->where('user_id', $doctor_id)
        ->orderBy('number', 'desc')
        ->whereIn('counter_id', $counter_id)
        ->first();
        }

        public function getLastRoomNumberQueue(Department $department, $pid='', $doctor_id = '', $counter_id = '')
        {
        return Queue::where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
        ->where('pid', $pid)
        ->where('user_id', $doctor_id)
        ->orderBy('number', 'desc')
        ->whereIn('counter_id', $counter_id)
        ->first();
        }

	
//--------------------------------------------------------	
}
