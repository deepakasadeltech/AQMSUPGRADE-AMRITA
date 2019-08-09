<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\DashbordRepository;
use App\Models\Call;
use App\Models\User;
use App\Models\Counter;
use App\Models\Setting;
use App\Models\Queue;
use Carbon\Carbon;
use App\Models\UhidMaster;
use App\Models\DoctorReport;
use App\Models\PatientCall;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Ad;
use App\Models\Review;




class DashboardController extends Controller
{
   protected $setting;

    public function __construct(DashbordRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {        $doctorrooms = $this->setting->getCounter();
                //--------doctor-multiroom-----------------------
                $doctroom = ''; $drm_id = '';
                if(!empty(Auth::user()->counter_id))
                {   $rooms_id = Auth::user()->counter_id;
                     $array_rooms_id =  explode(', ', $rooms_id); 
                    foreach($array_rooms_id as $room_id){
                     foreach($doctorrooms as $rooms){ 
                         if($rooms->id == $room_id ){$drm_id = $room_id;}
                       } 
                    }
                   }else{
                    $drm_id  = 'No';   
                   }

              //print_r($drm_id); die;

		return view('user.dashboard.index', [
			'setting' => $this->setting->getSetting(),
			'queuesetting' => $this->setting->getQueueSetting(),
            'today_queue' => $this->setting->getTodayQueue(),
            'missed' => $this->setting->getTodayMissed(),
            'overtime' => $this->setting->getTodayOverTime(),
            'served' => $this->setting->getTodayServed(),
            'counters' => $this->setting->getCounters(),
            'today_calls' => $this->setting->getTodayCalls(),
            'yesterday_calls' => $this->setting->getYesterdayCalls(),
			'patient_list' =>$this->setting->getPatientList(Auth::user()->pid, Auth::user()->department_id),
			'patient_list_doctorwise' =>$this->setting->getPatientListDoctorWise(Auth::user()->id, Auth::user()->department_id),
			'patient_seen' =>$this->setting->getPatientSeenList(Auth::user()->id),
			'role'=> Auth::user()->role,
			'pdepartments' => $this->setting->getPDepartmentName(Auth::user()->pid),
			'departments' => $this->setting->getDepartments(),
			'daily_avgtime_of_doctor' =>$this->setting->getDailyDoctorAvgTime(Auth::user()->id),
			'today_queue_bycounter' => $this->setting->getTodayQueueByCounter(Auth::user()->department_id),
			'today_called_bycounter' => $this->setting->getTodayPatientCalledByCounter(Auth::user()->department_id),
			'user_details' => $this->setting->getUserDetails(Auth::user()->pid, Auth::user()->department_id, Auth::user()->counter_id),
			'patient_called_bydoctor' =>$this->setting->getTodayPatientCalledByDoctor(Auth::user()->id),

			'users' => $this->setting->getUserDoctor(),
			'staffusers' => $this->setting->getUserStaff(),
			'pardepartments' => $this->setting->getPDepartments(),

			'totaldoctor_absent' => $this->setting->gettotalDoctorAbsent(),
			'totaldoctor_present' => $this->setting->gettotalDoctorPresent(),

			'get_all_department_total_queue_in_today' => $this->setting->getAllDepartmentTotalQueueInToday(),
			'get_all_department_total_called_in_today' => $this->setting->getAllDepartmentTotalCalledInToday(),
			'get_all_department_total_called_but_not_seen_today' => $this->setting->getAllDepartmentTotalCalledbutNotSeenToday(),
			'get_all_department_total_pending_for_call' => $this->setting->getAllDepartmentTotalpendingTokenForCallToday(),
			'get_all_department_doctor_Start_but_notSeen' => $this->setting->getAllDepartmentStartWorkbutNotEndToday(),

			'getTodayAvgConsultingTime' => $this->setting->getTodayAvgConsultingTime(),
			'getTodayAvgWaitingTime' => $this->setting->getTodayAvgWaitingTime(),
			'getTodaytpatienttoDoctor' => $this->setting->getTodaytpatienttoDoctor(),

			'today_queue_platinum' => $this->setting->getTodayPalatinump(Auth::user()->department_id),
			'today_queue_gold' => $this->setting->getTodayGoldp(Auth::user()->department_id),
			'today_queue_silver' => $this->setting->getTodaySilverp(Auth::user()->department_id),
		//--------Doctor-wise-token-function---------------------	 
'today_queue_bycounter_doctor' => $this->setting->getTodayQueueByCounterDoctor(Auth::user()->department_id, Auth::user()->id),

'platinum_patient' => $this->setting->getTodayPalatinumpDoctor(Auth::user()->department_id, Auth::user()->id),

'gold_patient' => $this->setting->getTodayGoldpDoctor(Auth::user()->department_id, Auth::user()->id),
'silver_patient' => $this->setting->getTodaySilverpDoctor(Auth::user()->department_id, Auth::user()->id),		
			
	//--------Start-Superadmin-Details-----------
		 'No_Of_Doctor' => $this->setting->No_Of_Doctor(),
		 'No_Of_Staff' => $this->setting->No_Of_Staff(),
		 'No_Of_Helpdesk' => $this->setting->No_Of_Helpdesk(),
		 'No_Of_CMO' => $this->setting->No_Of_CMO(),
		 'No_Of_Displayctrl' => $this->setting->No_Of_Displayctrl(),
		 'No_Of_Pdepartment' => $this->setting->No_Of_Pdepartment(),
		 'No_of_Department' => $this->setting->No_of_Department(),
		 'No_of_Counter' => $this->setting->No_of_Counter(),
		 'No_of_tokenPerDay' => $this->setting->No_of_tokenPerDay(),
		 'No_of_Ads' => $this->setting->No_of_Ads(),
	//--------End-Superadmin-Details-------------
	
	  'activedoctortoseereferrals' =>$this->setting->activeDoctorToseeRefererral(),
      'activedepttoseereferrals' =>$this->setting->getActiveDepartmentsToseeReferral(),
      'doctorrooms' => $this->setting->getCounter(),
      'doctorRoomsInQueue' => $this->setting->getDoctorRoomInQueue(),
	  'activedoctordispensary' =>$this->setting->activeDoctorDispensary(),
	//--------------------------------------------

		]);
  
		
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'notification' => 'bail|required|min:5',
            'size' => 'bail|required|numeric',
            'color' => 'required',
        ]);

        $setting = $this->setting->updateNotification($request->all());

        flash()->success('Notification updated');
        return redirect()->route('dashboard');
    }
	
	public function startCounter($id = '')
	{
		$pid = Auth::user()->pid;
		$department_id = Auth::user()->department_id;
		
		$isCallValid = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('id', $id)
		->where('pid', $pid)
		->where('department_id', $department_id)
		->count();
		if($isCallValid == 0){
			flash()->warning('Invalid  request');
			return redirect()->route('dashboard');
		}
		
		$calls = Call::find($id);
		$calls->view_status = 1;
		$calls->doctor_work_start = 1;
		$calls->doctor_work_start_date = date('Y-m-d H:i:s');
		$calls->save();
		
		//event(new \App\Events\CsvGenerate());
		//insert/update
		flash()->success('Token Time Start');
		return redirect()->route('dashboard');
		
    }
    


	
	public function endCounter( $id = '')
	{
		$pid = Auth::user()->pid;
		$department_id = Auth::user()->department_id;
		
		$isCallValid = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('id', $id)
		->where('pid', $pid)
		->where('department_id', $department_id)
		->count();
		
		if($isCallValid == 0){
			flash()->warning('Invalid  request');
			return redirect()->route('dashboard');
		}
		
		$calls = Call::find($id);
		$queue_id = $calls->queue_id;
		$start_time = $calls->doctor_work_start_date;
		$number = $calls->number;
		$end_time = date('Y-m-d H:i:s');
		$calls->doctor_work_end = 1;
		$calls->view_status = 3;
		$calls->doctor_work_end_date = $end_time;
		$calls->view_status = 0;
		$calls->save();
		$queue = Queue::find($queue_id);
		$queue->queue_status = 0;
		$queue->save();
		
		
		//departments
		$departments = Department::find($department_id);
		//insert in reports
		$reports = new DoctorReport();
		$reports->call_id = $id;
		$reports->department_id = $department_id;
		$reports->user_id = Auth::user()->id;
		$reports->pid = $pid;
		$reports->token_number = $departments->letter.''.$number;
		$reports->start_time = $start_time;
		$reports->end_time = $end_time;
        $reports->save();

	//---------------------------------------------------------------------
	    event(new \App\Events\CsvGenerate());	
		event(new \App\Events\TokenCalled());
		event(new \App\Events\TokenCalled2());
		//event(new \App\Events\TokenIssued());
		flash()->success('Token Closed');
		return redirect()->route('dashboard');
		
	}

	public function doctorDirectCall(Request $request)
    { 
        $this->validate($request, [
            'user' => 'bail|required|exists:users,id',
            'counter' => 'bail|required|exists:counters,id',
            'pid' => 'bail|required|exists:parent_departments,id',
			'department' => 'bail|required|exists:departments,id',
		]);
		
		$user = User::findOrFail($request->user);
        $counter = Counter::findOrFail($request->counter);
        $pdepartment = ParentDepartment::findOrFail($request->pid);
        $department = Department::findOrFail($request->department);
        

         //--------doctor-multiroom-----------------------
         $doctroom = '';
         $rooms_id = $user->counter_id;
         $array_rooms_id =  explode(', ', $rooms_id); 
         $rand_room = array_rand($array_rooms_id);
         $ddroom = $array_rooms_id[$rand_room];
         $last_room = $this->setting->getLastRoomNumber($department, $user->pid, $user->id, $array_rooms_id);
         $keys = array_keys($array_rooms_id);    
         if(!empty($last_room->counter_id)){ 

         for($i = 0; $i < count($array_rooms_id)-1; $i++){
         if($last_room->counter_id == $array_rooms_id[$i]){
         $doctroom = $array_rooms_id[next($keys)+$i];
         }
         }

         if($last_room->counter_id == end($array_rooms_id)){
         $doctroom = $array_rooms_id[reset($keys)];
         }

         }else{ $doctroom = $array_rooms_id[reset($keys)]; }

         $counter = Counter::where('id', $doctroom)->where('pid', $user->pid)->where('department_id', $user->department_id)->first();
       //----------------------------------------  

		$queueByPriority = $this->setting->getNextTokenByPriority($department);
		//dd($queueByPriority[0]['id']);
		if(!isset($queueByPriority[0]['id']) || empty($queueByPriority[0]['id'])) {
            flash()->warning('No Token for this department');
            return redirect()->route('dashboard');
		}
		$queue = Queue::find($queueByPriority[0]['id']);

		//$queue = $this->setting->getNextToken($department);
		
		if($queue==null) {
            flash()->warning('No Token for this department');
            return redirect()->route('dashboard');
		}
		
		$call = $queue->call()->create([
            'pid' => $pdepartment->id,
			'department_id' => $department->id,
            'counter_id' => $doctroom,
			'user_id' => $user->id,
			'ads_id' => $user->ads_id,
			'number' => $queue->number,
            'priority' => $queue->priority,
            'view_status' => 1,
            'called_date' => Carbon::now()->format('Y-m-d'),
		]);
		
		$queue->called = 1;
		$queue->save();
		
        $request->session()->flash('pdepartment', $pdepartment->id);
        $request->session()->flash('department', $department->id);
        $request->session()->flash('counter', $counter->name);

        //event(new \App\Events\TokenIssued());
        event(new \App\Events\TokenCalled());
        event(new \App\Events\TokenCalled2());
        flash()->success('Token Called');

        
        return redirect()->route('dashboard');
	}
	

//----------=======Start=Calling-token-Doctor-wise============-----------

public function doctorDirectCallOurToken(Request $request)
    { 
        $this->validate($request, [
            'user' => 'bail|required|exists:users,id',
            'counter' => 'bail|required|exists:counters,id',
            'pid' => 'bail|required|exists:parent_departments,id',
			'department' => 'bail|required|exists:departments,id',
		]);
		
        $user = User::findOrFail($request->user);
        $counter = Counter::findOrFail($request->counter);
        $pdepartment = ParentDepartment::findOrFail($request->pid);
        $department = Department::findOrFail($request->department);


        
       
    //--------------------------------------------   
    $rooms_id = $request->counter; $doctroom = '';
    $array_rooms_id =  explode(', ', $rooms_id);
    $rand_room = array_rand($array_rooms_id);
    $docroom = $array_rooms_id[$rand_room]; 
    //$counter = Counter::where('id', $docroom)->first();
     $doctroom = $docroom; 
   
      // print_r($doctroom); die;
    //----------------------------------------------  
      
       $queueByPriority = $this->setting->getNextTokenByPriorityDoctor($department, $user->id, $docroom);
       $queue = Queue::find($queueByPriority[0]['id']); 
		if($queue==null) {
            flash()->warning('No Token for this department');
            return redirect()->route('dashboard');
		}

		
		//dd($queueByPriority[0]['id']);
		if(!isset($queueByPriority[0]['id']) || empty($queueByPriority[0]['id'])) {
            flash()->warning('No Token for this department');
            return redirect()->route('dashboard');
		}
		

        //$queue = $this->setting->getNextToken($department);
        
		$call = $queue->call()->create([
            'pid' => $pdepartment->id,
			'department_id' => $department->id,
            'counter_id' => $queue->counter_id,
			'user_id' => $user->id,
			'ads_id' => $user->ads_id,
			'number' => $queue->number,
            'priority' => $queue->priority,
            'view_status' => 1,
            'called_date' => Carbon::now()->format('Y-m-d'),
        ]);
        
		$queue->called = 1;
		$queue->save();
		
        $request->session()->flash('pdepartment', $pdepartment->id);
        $request->session()->flash('department', $department->id);
        $request->session()->flash('counter', $queue->counter_id);

        //event(new \App\Events\TokenIssued());
		event(new \App\Events\TokenCalled());
		event(new \App\Events\TokenCalled2());

        flash()->success('Token Called');

        
        return redirect()->route('dashboard');
	}	
	


//----------=======End=Calling-token-Doctor-wise================------------


	public function PatientStatus($id='')
	{   

		$alreadyActivated = Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('user_id', Auth::user()->id)
		->where('view_status', 1)
		->where('id', '!=',$id)
		->count();
		/*if($alreadyActivated > 0){
			flash()->warning("You have already called a patient");
			return redirect()->route('dashboard');
		}*/
		
		$calls = Call::find($id);
		
		if($calls->view_status == 0) {
            $calls->view_status = 1;
            $msg = "Token No. Display ON";
        }else{
            $calls->view_status = 0;
            $msg = "Token No. Display OFF";
        }


		//--------------------------------------
		event(new \App\Events\CsvGenerate());
		event(new \App\Events\TokenCalled());
		event(new \App\Events\TokenCalled2());

		//$calls->view_status = 1;
	
		$calls->save();
		
		
		flash()->success($msg);
		return redirect()->route('dashboard');



	}
	
//----------------------------------------------------------------	

//--------------Start-token-doctor-wise------------
public function referToDoctor(Request $request, $doctor = '')
{  
	$request->session()->flash('printFlag', true);
		  //------------------------------------
		  $referraldoctor = $request->doctor;
		  //------------------------------------	
				if($referraldoctor == ''){
					$request->session()->flash('printFlag', false);
					flash()->warning('Please Select Doctor');
					return redirect()->route('dashboard');	
				}
			  //---------------------------------------
      $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
      $user = User::findOrFail($request->doctor);
      $counter = User::with('counter')->findorFail($user->id);
      $department = Department::findOrFail($user->department_id);
      $is_uhid_required = $this->isUhidRequired($department->id);
      $priority = 4;//by default normal
      $uhid = 500;
      //var_dump($is_uhid_required);die;
      if($is_uhid_required){
          
         if($is_uhid_required==1){
           $uhid = $request->uhid;
           $priority = $is_uhid_required;
          }
           else{
              $uhid = 500;
              $priority = 4;
           }
          
        $is_uhid_exist = $this->isUHIDExist($uhid);
          if(!$is_uhid_exist) {
              $request->session()->flash('printFlag', false);
              flash()->warning('Invalid UHID');
              return redirect()->route('dashboard');
          }
	  }
	  

      //---------
      $todaydate = date('m').substr(date('Y'),2); 
      $dublicate = $department->regcode.$todaydate.$request->registration;   
      $get_Registration = $this->setting->getRegistNumber($dublicate);

      $reqregistration = $request->registration;
  //------------------------------------	
  if($reqregistration == ''){
      $request->session()->flash('printFlag', false);
      flash()->warning('Please Enter 5 digits Only Number');
      return redirect()->route('dashboard');	
  }
  //-------------------------------------
      $pattern = '~^[0-9]{5}+$~';
      if(!preg_match($pattern, $reqregistration)){
         $request->session()->flash('printFlag', false);
         flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
         return redirect()->route('dashboard');	 
      }else{
          echo 'yes';
      }
  //---------------------------------------
      
          if($get_Registration > 0){
              $request->session()->flash('printFlag', false);
              flash()->warning('This Registration Number All Ready Exist');
              return redirect()->route('dashboard');
          }
      //------------

      if(!empty($uhid)){
          $uhid_details = UhidMaster::where('uhid', $uhid)->first();
          if(!empty($uhid_details)){
              $priority = $uhid_details['priority_type'];
          }
          
      }

            //--------doctor-multiroom-----------------------
            $doctroom = '';
            $rooms_id = $user->counter_id;
            $array_rooms_id =  explode(', ', $rooms_id); 
            $rand_room = array_rand($array_rooms_id);
            $ddroom = $array_rooms_id[$rand_room];
            $last_room = $this->setting->getLastRoomNumber($department, $user->pid, $user->id, $array_rooms_id);
            $keys = array_keys($array_rooms_id);    
            if(!empty($last_room->counter_id)){ 

            for($i = 0; $i < count($array_rooms_id)-1; $i++){
            if($last_room->counter_id == $array_rooms_id[$i]){
            $doctroom = $array_rooms_id[next($keys)+$i];
            }
            }

            if($last_room->counter_id == end($array_rooms_id)){
            $doctroom = $array_rooms_id[reset($keys)];
            }

            }else{ $doctroom = $array_rooms_id[reset($keys)]; }

            $counter = Counter::where('id', $doctroom)->where('pid', $user->pid)->where('department_id', $user->department_id)->first();
            //---------------------------------------- 

      //--------Review-Flag-------------------
      $referralflag = $request->referralflag; $referral = '';
      if($referralflag == 'F'){
          $referral = 'F';
      }else{
          $referral = NULL;
      }
      // print_r($background); die;

      //---pname-pmobile-pemail---------------
      $pname_p = $request->pname;
      $pmobile_p = $request->pmobile;
      $pemail_p = $request->pemail;
      $pname = ''; $pmobile = ''; $pemail = '';
      if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
      if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
      if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
      //print_r($pname.' '.$pmobile.' '.$pemail); die;
      //--------------------------------------
      $last_token = $this->setting->getLastTokenDoctor($department);
      $total = $this->setting->getCustomersWaiting($department, $priority);
     
      if($last_token) {
          $tokenNumber = ((int)$last_token->number)+1;
          $istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
          if($istkenExist > 0){
              $request->session()->flash('printFlag', false);
              flash()->warning('Token already issued');
              return redirect()->route('dashboard');
          }
         
      
          $queue = $department->queues()->create([
              'pid' => $user->pid,
              'number' => ((int)$last_token->number)+1,
              'pname' => $pname,
              'pmobile' => $pmobile,
              'pemail' => $pemail,
              'token_type' => $referral,
			  'regnumber' => 'REF'.$department->regcode.$todaydate.$request->registration,
			  'refer_by' => Auth::user()->name,
              'called' => 0,
              'uhid' => $uhid,
              'priority' => $priority,
              'department_id' => $request->department_id,
              'counter_id' => $doctroom,
              'user_id' => $user->id,
              'customer_waiting' => $total,
          ]);
      } else {
          $tokenNumber = $department->start;
          $istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
          if($istkenExist > 0){
              $request->session()->flash('printFlag', false);
              flash()->warning('Token already issued');
              return redirect()->route('dashboard');
          }
          $queue = $department->queues()->create([
              'pid' => $user->pid,
              'number' => $department->start,
              'pname' => $pname,
              'pmobile' => $pmobile,
              'pemail' => $pemail,
              'token_type' => $referral,
			  'regnumber' => 'REF'.$department->regcode.$todaydate.$request->registration,
			  'refer_by' => Auth::user()->name,
              'called' => 0,
              'uhid' => $uhid,
              'priority' => $priority,
              'department_id' => $request->department_id,
              'counter_id' => $doctroom,
              'user_id' => $user->id,
              'customer_waiting' => $total
          ]);
      }
     // print_r($user->toArray()); die;
      
      $total = $this->setting->getCustomersWaiting($department, $priority);
      $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
      //event(new \App\Events\TokenIssued());

              //--------start-Token-detail-on-mail---------------
		
		/*if($request->pemail !== ''){	
            $name = [
                'token' => ($department->letter!='')?$department->letter.''.$queue->number:$queue->number,
                'department_name' => $department->name,
                'doctor_name' => $user->name,
                'room_number' => $counter->counter->name,
                'total' => $total,
            ];
            $mail = Mail::to($request->pemail)->send(new SendMailable($name));
               } */
            //-----------End-Token-detail-on-mail----------------

      $request->session()->flash('registration_no',  'REF'.$department->regcode.$todaydate.$request->registration);
      $request->session()->flash('doctor_department', $department->name);
      $request->session()->flash('user_name', $user->name);
      $request->session()->flash('room_number', $counter->name);
      $request->session()->flash('patient_name', $pname);
      $request->session()->flash('patient_mobile', $pmobile);
      $request->session()->flash('patient_email', $pemail);
      $request->session()->flash('number', ($department->letter!='')?$department->letter.''.$queue->number:$queue->number);
      $request->session()->flash('total', $total-1);
      $request->session()->flash('uhid', $uhid);
      $request->session()->flash('referral', $referral);
	  $request->session()->flash('referred_by', Auth::user()->name);
      $request->session()->flash('priority', $priority_details['priority_type']); 
      flash()->success('You have been referred to '.$user->name);
	return redirect()->route('dashboard');
}

//--------------End-token-doctor-wise--------------

//--------------Start-token-department-wise-----------

public function referToDepartment(Request $request, $department = '')
    {   
        $request->session()->flash('printFlag', true);
        //------------------------------------
		  $referraldepartment = $request->department;
		  //------------------------------------	
				if($referraldepartment == ''){
					$request->session()->flash('printFlag', false);
					flash()->warning('Please Select Department');
					return redirect()->route('dashboard');	
				}
			  //---------------------------------------
		$department = Department::findOrFail($request->department);
        $is_uhid_required = $this->isUhidRequired($department->id);
        $priority = 4;//by default normal
        $uhid = 500;

		if($is_uhid_required){

			if($is_uhid_required==1){
                $uhid = $request->uhid;
                $priority = $is_uhid_required;
               }
                else{
                   $uhid = 500;
                   $priority = 4;
                }

			$is_uhid_exist = $this->isUHIDExist($uhid);
			if(!$is_uhid_exist) {
				$request->session()->flash('printFlag', false);
				flash()->warning('Invalid UHID');
				return redirect()->route('dashboard');
			}
        }
        
		//------------
        $todaydate = date('m').substr(date('Y'),2);
        $dublicate = $department->regcode.$todaydate.$request->registration;
        $get_Registration = $this->setting->getRegistNumber($dublicate);
         
        $reqregistration = $request->registration;
	//------------------------------------	
	if($reqregistration == ''){
		$request->session()->flash('printFlag', false);
		flash()->warning('Please Enter 5 digits Only Number');
		return redirect()->route('dashboard');	
	}
	//-------------------------------------
		$pattern = '~^[0-9]{5}+$~';
		if(!preg_match($pattern, $reqregistration)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
		   return redirect()->route('dashboard');	 
		}else{
			echo 'yes';
		}
    //---------------------------------------

        if($get_Registration > 0){
            $request->session()->flash('printFlag', false);
            flash()->warning('This Registration Number All Ready Exist');
            return redirect()->route('dashboard');
        }
      //--------------
      if(!empty($uhid)){
        $uhid_details = UhidMaster::where('uhid', $uhid)->first();
        if(!empty($uhid_details)){
            $priority = $uhid_details['priority_type'];
        }
        
    }

            //--------Review-Flag-------------------
            $referralflag = $request->referralflag; $referral = '';
            if($referralflag == 'F'){
                $referral = 'F';
            }else{
                $referral = NULL;
            }
            // print_r($background); die;

          //---pname-pmobile-pemail---------------
          $pname_p = $request->pname;
          $pmobile_p = $request->pmobile;
          $pemail_p = $request->pemail;
          $pname = ''; $pmobile = ''; $pemail = '';
          if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
          if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
          if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
          //print_r($pname.' '.$pmobile.' '.$pemail); die;
          //--------------------------------------
        $last_token = $this->setting->getLastToken($department);
        $total = $this->setting->getCustomersWaiting($department, $priority);

        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('dashboard');
            }
            
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => ((int)$last_token->number)+1,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $referral,
				'regnumber' => 'REF'.$department->regcode.$todaydate.$request->registration,
				'refer_by' => Auth::user()->name,
                'called' => 0,
                'uhid' => $uhid,
                'priority' => $priority,
                'customer_waiting' => $total
            ]);
        } else {
			$tokenNumber = $department->start;
			$istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('dashboard');
			}
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => $department->start,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $referral,
				'regnumber' => 'REF'.$department->regcode.$todaydate.$request->registration,
				'refer_by' => Auth::user()->name,
                'called' => 0,
                'uhid' => $uhid,
                'priority' => $priority,
                'customer_waiting' => $total
            ]);
        }

        $total = $this->setting->getCustomersWaiting($department, $priority);
		$priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        //event(new \App\Events\TokenIssued());
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
                //--------start-Token-detail-on-mail---------------
		
		/*if($request->pemail !== ''){	
            $name = [
                'token' => ($department->letter!='')?$department->letter.''.$queue->number:$queue->number,
                'department_name' => $department->name,
                'doctor_name' => '',
                'room_number' => '',
                'total' => $total,
            ];
            $mail = Mail::to($request->pemail)->send(new SendMailable($name));
               }*/
            //-----------End-Token-detail-on-mail----------------
        $request->session()->flash('registration_no',  'REF'.$department->regcode.$todaydate.$request->registration);
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.'-'.$queue->number:$queue->number);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
        $request->session()->flash('total', $total-1);
        $request->session()->flash('uhid', $uhid);
        $request->session()->flash('referral', $referral);
		$request->session()->flash('referred_by', Auth::user()->name);
        $request->session()->flash('priority', $priority_details['priority_type']);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);


        flash()->success('You have been referred to '.$department->name);
        return redirect()->route('dashboard');
    }

//--------------End-token-department-wise-------------
//--------------Start-Review------------
public function patientReview(Request $request, $id = '')
{  
	
      $revpatient = Call::with('queue')->where('id', $request->id)->first();
      $call_id = $revpatient->id;
      $revdublicate = Review::where('call_id', $call_id)->get();
      //echo '<pre>'; print_r($revdublicate->toArray());die;
      //echo '<pre>' ; print_r($revpatient->toArray()); die;
      //echo $revdublicate; die;
     
      if(count($revdublicate) > 0){
        flash()->warning('This patient already for next day review');
        $request->session()->flash('reviewcall', $revpatient->id);
        $request->session()->flash('number', $revpatient->number);
        $request->session()->flash('patient_name', $revpatient->queue->pname);
        return redirect()->route('dashboard');
      }

      //---pname-pmobile-pemail---------------
      $pname_p = $revpatient->queue->pname;
      $pmobile_p = $revpatient->queue->pmobile;
      $pemail_p = $revpatient->queue->pemail;
      $pname = ''; $pmobile = ''; $pemail = '';
      if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
      if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
      if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
      //print_r($pname.' '.$pmobile.' '.$pemail); die;
      //--------------------------------------
      
      Review::create([
              'call_id' => $revpatient->id,
              'pid' => $revpatient->pid,
              'number' => $revpatient->number,
              'pname' => $pname,
              'pmobile' => $pmobile,
              'pemail' => $pemail,
			  'revnumber' => 'REV'.$revpatient->queue->regnumber,
			  'last_seen_by' => Auth::user()->name,
			  'last_seen_date' => date('d.m.Y'),
              'department_id' => $revpatient->department_id,
              'counter_id' => $revpatient->counter_id,
              'user_id' => $revpatient->user_id,
          ]);
      
     
    
      //event(new \App\Events\TokenIssued());

              //--------start-Token-detail-on-mail---------------
		
		/*if($request->pemail !== ''){	
            $name = [
                'token' => ($department->letter!='')?$department->letter.''.$queue->number:$queue->number,
                'department_name' => $department->name,
                'doctor_name' => $user->name,
                'room_number' => $counter->counter->name,
                'total' => $total,
            ];
            $mail = Mail::to($request->pemail)->send(new SendMailable($name));
               } */
            //-----------End-Token-detail-on-mail----------------
            $request->session()->flash('reviewcall', $revpatient->id);
            $request->session()->flash('number', $revpatient->number);
            $request->session()->flash('patient_name', $revpatient->queue->pname);
      flash()->success('review Done');
	return redirect()->route('dashboard');
}

//--------------End-Review--------------

private function isUhidRequired($department_id)
	{
		$flag = false;
		$result = Department::find($department_id);
		if(!empty($result)){
			$flag = ($result->is_uhid_required == 1) ? true : false;
		}
		return $flag;
	}
	
	private function isUHIDExist($uhid)
	{
		$flag = false;
		$result = UhidMaster::where('uhid', $uhid)->count();
		$flag = ($result > 0) ? true : false;
		return $flag;
    }



//--------------------====Start=Dispensary-with-End-counter================----------------	

public function endCounterWithDispensaryDoctor(Request $request, $id = '')
	{      
           
        $request->session()->flash('printFlag', true);
        $queuesetting = $this->setting->getQueueSetting();
        
         $calls = Call::with('queue')->find($id);
      //echo '<pre>'; print_r($calls->queue->pmobile); die;
        //------------------------------------
          //$referraldepartment = $request->department;
          $dispensarydoctor = $request->doctor;
		  //------------------------------------	
				if($dispensarydoctor == ''){
					$request->session()->flash('printFlag', false);
					flash()->warning('Please Select Dispensary Doctor');
					return redirect()->route('dashboard');	
				}
              //---------------------------------------
        $user = User::findOrFail($dispensarydoctor);      
        $department = Department::findOrFail($user->department_id);
       // print_r($department->name.' '.$queuesetting->dispensary_id); die;
        $is_uhid_required = $this->isUhidRequired($department->id);
        $priority = 4;//by default normal
        $uhid = 500;

		if($is_uhid_required){

			if($is_uhid_required==1){
                //$uhid = $request->uhid;
                $priority = $is_uhid_required;
               }
                else{
                   $uhid = 500;
                   $priority = 4;
                }

			$is_uhid_exist = $this->isUHIDExist($uhid);
			if(!$is_uhid_exist) {
				$request->session()->flash('printFlag', false);
				flash()->warning('Invalid UHID');
				return redirect()->route('dashboard');
			}
        }
        
        $reqregistration = rand(10000 , 99999);
		//------------
        $todaydate = date('m').substr(date('Y'),2);
        $dublicate = $department->regcode.$todaydate.$reqregistration;
        $get_Registration = $this->setting->getRegistNumber($dublicate);
         
        //$reqregistration = $request->registration;
	//------------------------------------	
	if($reqregistration == ''){
		$request->session()->flash('printFlag', false);
		flash()->warning('Please Enter 5 digits Only Number');
		return redirect()->route('dashboard');	
	}
	//-------------------------------------
		$pattern = '~^[0-9]{5}+$~';
		if(!preg_match($pattern, $reqregistration)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
		   return redirect()->route('dashboard');	 
		}else{
			echo 'yes';
		}
    //---------------------------------------

        if($get_Registration > 0){
            $request->session()->flash('printFlag', false);
            flash()->warning('This Registration Number All Ready Exist');
            return redirect()->route('dashboard');
        }
      //--------------
      if(!empty($uhid)){
        $uhid_details = UhidMaster::where('uhid', $uhid)->first();
        if(!empty($uhid_details)){
            $priority = $uhid_details['priority_type'];
        }
        
    }
    

            //--------Review-Flag-------------------
            $dispensaryflag = 'M'; $dispflag = '';
            if($dispensaryflag == 'M'){
                $dispflag = 'M';
            }else{
                $dispflag = NULL;
            }

            //--------doctor-multiroom-----------------------
           //--------doctor-multiroom-----------------------
         $doctroom = '';
         $rooms_id = $user->counter_id;
         $array_rooms_id =  explode(', ', $rooms_id); 
         $rand_room = array_rand($array_rooms_id);
         $ddroom = $array_rooms_id[$rand_room];
         $last_room = $this->setting->getLastRoomNumberQueue($department, $user->pid, $user->id, $array_rooms_id);
         $keys = array_keys($array_rooms_id);    
         if(!empty($last_room->counter_id)){ 

         for($i = 0; $i < count($array_rooms_id)-1; $i++){
         if($last_room->counter_id == $array_rooms_id[$i]){
         $doctroom = $array_rooms_id[next($keys)+$i];
         }
         }

         if($last_room->counter_id == end($array_rooms_id)){
         $doctroom = $array_rooms_id[reset($keys)];
         }

         }else{ $doctroom = $array_rooms_id[reset($keys)]; }

         $counter = Counter::where('id', $doctroom)->where('pid', $user->pid)->where('department_id', $user->department_id)->first();
       //---------------------------------------- 


          //---pname-pmobile-pemail---------------
          $queuemobile = $request->pmobile ; $mobileyesno = '';
          $requestmobile = $request->pmobilevd;
          if($request->pmobilevd == 'undefined'){
            $mobileyesno = $queuemobile;
          }else{$mobileyesno = $requestmobile;}
           
          $patternmobile = '~^[0-9]{10}+$~';
          if(($mobileyesno == '')||(!preg_match($patternmobile, $mobileyesno))){
            $request->session()->flash('printFlag', false);
            flash()->warning('Please Enter Correct Mobile Number');
            return redirect()->route('dashboard');	
            }

          //print_r('c mobile: '.$mobileyesno); die;

          $pname_p = $calls->queue->pname;
          $pmobile_p = $mobileyesno;
          $pemail_p = $calls->queue->pemail;
          $pname = ''; $pmobile = ''; $pemail = '';
          if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
          if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
          if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
               
          //print_r($pname.''.$pmobile);die;

               
        $last_token = $this->setting->getLastToken($department);
        $total = $this->setting->getCustomersWaiting($department, $priority);

        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('dashboard');
            }
            
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => ((int)$last_token->number)+1,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $dispflag,
				'regnumber' => $department->regcode.$todaydate.$reqregistration,
				'refer_by' => Auth::user()->name,
                'called' => 0,
                'uhid' => $uhid,
                'priority' => $priority,
                'department_id' => $request->department_id,
                'counter_id' => $doctroom,
                'user_id' => $user->id,
                'customer_waiting' => $total
            ]);
        } else {
			$tokenNumber = $department->start;
			$istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('dashboard');
			}
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => $department->start,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $dispflag,
				'regnumber' => $department->regcode.$todaydate.$reqregistration,
				'refer_by' => Auth::user()->name,
                'called' => 0,
                'uhid' => $uhid,
                'priority' => $priority,
                'department_id' => $request->department_id,
                'counter_id' => $doctroom,
                'user_id' => $user->id,
                'customer_waiting' => $total
            ]);
        }

        $total = $this->setting->getCustomersWaiting($department, $priority);
		$priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $request->session()->flash('registration_no',  $department->regcode.$todaydate.$reqregistration);
        $request->session()->flash('dispensary', $department->name);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.'-'.$queue->number:$queue->number);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
        $request->session()->flash('room_number', $counter->name);
        $request->session()->flash('doctor_name', $user->name);
        $request->session()->flash('total', $total-1);
        $request->session()->flash('uhid', $uhid);
        $request->session()->flash('dispensary_doctor', Auth::user()->name);
        $request->session()->flash('patient_type', $dispflag);
		$request->session()->flash('referred_by', Auth::user()->name);
        $request->session()->flash('priority', $priority_details['priority_type']);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);
     //-----------------------------------------------------------------------

		$pid = Auth::user()->pid;
		$department_id = Auth::user()->department_id;
		$isCallValid = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('id', $id)
		->where('pid', $pid)
		->where('department_id', $department_id)
		->count();
		
		if($isCallValid == 0){
			flash()->warning('Invalid  request');
			return redirect()->route('dashboard');
		}
		
		//$calls = Call::find($id);
		$queue_id = $calls->queue_id;
		$start_time = $calls->doctor_work_start_date;
		$number = $calls->number;
		$end_time = date('Y-m-d H:i:s');
		$calls->doctor_work_end = 1;
		$calls->view_status = 3;
		$calls->doctor_work_end_date = $end_time;
		$calls->view_status = 0;
		$calls->save();
		$queue = Queue::find($queue_id);
		$queue->queue_status = 0;
		$queue->save();
		//departments
		$departments = Department::find($department_id);
		//insert in reports
		$reports = new DoctorReport();
		$reports->call_id = $id;
		$reports->department_id = $department_id;
		$reports->user_id = Auth::user()->id;
		$reports->pid = $pid;
		$reports->token_number = $departments->letter.''.$number;
		$reports->start_time = $start_time;
		$reports->end_time = $end_time;
        $reports->save();
	//---------------------------------------------------------------------
	    event(new \App\Events\CsvGenerate());	
		event(new \App\Events\TokenCalled());
		event(new \App\Events\TokenCalled2());
		//event(new \App\Events\TokenIssued());
		flash()->success('Token Closed');
		return redirect()->route('dashboard');
		
    }
    

//---------------Department-wise-below--------------------------------------

    public function endCounterWithDispensaryDepartment(Request $request, $id = '')
	{
        
        $request->session()->flash('printFlag', true);
        $queuesetting = $this->setting->getQueueSetting();
      $calls = Call::with('queue')->find($id);
       // print_r($request->pmobilenumber); die;
      //echo '<pre>'; print_r($calls->queue->pmobile); die;
        //------------------------------------
          //$referraldepartment = $request->department;
          $dispensarydepartment = $queuesetting->dispensary_id;
		  //------------------------------------	
				if($dispensarydepartment == ''){
					$request->session()->flash('printFlag', false);
					flash()->warning('Please Select Department');
					return redirect()->route('dashboard');	
				}
			  //---------------------------------------
		$department = Department::findOrFail($dispensarydepartment);
        $is_uhid_required = $this->isUhidRequired($department->id);
        $priority = 4;//by default normal
        $uhid = 500;

		if($is_uhid_required){

			if($is_uhid_required==1){
                //$uhid = $request->uhid;
                $priority = $is_uhid_required;
               }
                else{
                   $uhid = 500;
                   $priority = 4;
                }

			$is_uhid_exist = $this->isUHIDExist($uhid);
			if(!$is_uhid_exist) {
				$request->session()->flash('printFlag', false);
				flash()->warning('Invalid UHID');
				return redirect()->route('dashboard');
			}
        }
        
        $reqregistration = rand(10000 , 99999);
		//------------
        $todaydate = date('m').substr(date('Y'),2);
        $dublicate = $department->regcode.$todaydate.$reqregistration;
        $get_Registration = $this->setting->getRegistNumber($dublicate);
         
        //$reqregistration = $request->registration;
	//------------------------------------	
	if($reqregistration == ''){
		$request->session()->flash('printFlag', false);
		flash()->warning('Please Enter 5 digits Only Number');
		return redirect()->route('dashboard');	
	}
	//-------------------------------------
		$pattern = '~^[0-9]{5}+$~';
		if(!preg_match($pattern, $reqregistration)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
		   return redirect()->route('dashboard');	 
		}else{
			echo 'yes';
		}
    //---------------------------------------

        if($get_Registration > 0){
            $request->session()->flash('printFlag', false);
            flash()->warning('This Registration Number All Ready Exist');
            return redirect()->route('dashboard');
        }
      //--------------
      if(!empty($uhid)){
        $uhid_details = UhidMaster::where('uhid', $uhid)->first();
        if(!empty($uhid_details)){
            $priority = $uhid_details['priority_type'];
        }
        
    }

            //--------Review-Flag-------------------
            $dispensaryflag = 'M'; $dispflag = '';
            if($dispensaryflag == 'M'){
                $dispflag = 'M';
            }else{
                $dispflag = NULL;
            }

          //---pname-pmobile-pemail---------------
          $queuemobile = $calls->queue->pmobile ; $mobileyesno = '';
          $requestmobile = $request->pmobilenumber;
         // print_r($queuemobile);die;
          if($calls->queue->pmobile !== NULL){
            $mobileyesno = $queuemobile;
          }else{$mobileyesno = $requestmobile;}
          $pname_p = $calls->queue->pname;
          $pmobile_p = $mobileyesno;
          $pemail_p = $calls->queue->pemail;
          $pname = ''; $pmobile = ''; $pemail = '';
          if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
          if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
          if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
               
         // print_r($pname.''.$pmobile);die;

               
        $last_token = $this->setting->getLastToken($department);
        $total = $this->setting->getCustomersWaiting($department, $priority);

        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('dashboard');
            }
            
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => ((int)$last_token->number)+1,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $dispflag,
				'regnumber' => $department->regcode.$todaydate.$reqregistration,
				'refer_by' => Auth::user()->name,
                'called' => 0,
                'uhid' => $uhid,
                'priority' => $priority,
                'customer_waiting' => $total
            ]);
        } else {
			$tokenNumber = $department->start;
			$istkenExist = $this->setting->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('dashboard');
			}
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => $department->start,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $dispflag,
				'regnumber' => $department->regcode.$todaydate.$reqregistration,
				'refer_by' => Auth::user()->name,
                'called' => 0,
                'uhid' => $uhid,
                'priority' => $priority,
                'customer_waiting' => $total
            ]);
        }

        $total = $this->setting->getCustomersWaiting($department, $priority);
		$priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $request->session()->flash('registration_no',  $department->regcode.$todaydate.$reqregistration);
        $request->session()->flash('dispensary', $department->name);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.'-'.$queue->number:$queue->number);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
        $request->session()->flash('total', $total-1);
        $request->session()->flash('uhid', $uhid);
        $request->session()->flash('dispensary_department', Auth::user()->name);
        $request->session()->flash('patient_type', $dispflag);
		$request->session()->flash('referred_by', Auth::user()->name);
        $request->session()->flash('priority', $priority_details['priority_type']);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);
     //-----------------------------------------------------------------------

		$pid = Auth::user()->pid;
		$department_id = Auth::user()->department_id;
		$isCallValid = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('id', $id)
		->where('pid', $pid)
		->where('department_id', $department_id)
		->count();
		
		if($isCallValid == 0){
			flash()->warning('Invalid  request');
			return redirect()->route('dashboard');
		}
		
		//$calls = Call::find($id);
		$queue_id = $calls->queue_id;
		$start_time = $calls->doctor_work_start_date;
		$number = $calls->number;
		$end_time = date('Y-m-d H:i:s');
		$calls->doctor_work_end = 1;
		$calls->view_status = 3;
		$calls->doctor_work_end_date = $end_time;
		$calls->view_status = 0;
		$calls->save();
		$queue = Queue::find($queue_id);
		$queue->queue_status = 0;
		$queue->save();
		//departments
		$departments = Department::find($department_id);
		//insert in reports
		$reports = new DoctorReport();
		$reports->call_id = $id;
		$reports->department_id = $department_id;
		$reports->user_id = Auth::user()->id;
		$reports->pid = $pid;
		$reports->token_number = $departments->letter.''.$number;
		$reports->start_time = $start_time;
		$reports->end_time = $end_time;
        $reports->save();
	//---------------------------------------------------------------------
	    event(new \App\Events\CsvGenerate());	
		event(new \App\Events\TokenCalled());
		event(new \App\Events\TokenCalled2());
		//event(new \App\Events\TokenIssued());
		flash()->success('Token Closed');
		return redirect()->route('dashboard');
		
	}


//--------------------====Start=Dispensary-with-End-counter================----------------	


}
