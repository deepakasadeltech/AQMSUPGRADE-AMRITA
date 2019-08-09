<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CallRepository;
use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Counter;
use App\Models\Call;
use App\Models\Queue;
use App\Models\UhidMaster;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\QueueSetting;
use App\Models\Review;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class CallController extends Controller
{
    protected $calls;

    public function __construct(CallRepository $calls)
    {
        $this->calls = $calls;
    }

    public function index(Request $request)
    {   
		$this->authorize('access', Call::class);
       // event(new \App\Events\TokenIssued());
        $settings = Setting::first();
        return view('user.calls.index', [
            'settings' => $settings,
            'users' => $this->calls->getUsers(),
            'counters' => $this->calls->getCounters(),
			'pdepartments' => $this->calls->getPDepartments(),
            'departments' => $this->calls->getActiveDepartments(),
            'kiosksetting' => $this->calls->queueSetting(),
            'activedoctors' => $this->calls->getActiveDoctors(),
            'currenttokens' => $this->calls->currentToken(),
            'currenttokensdoctors' => $this->calls->currentTokenDoctor(),
        ]);
    }

    //----------------------------------------------
public function tokenmodify(){
    //$this->authorize('access', Call::class);
    $settings = Setting::first();
    return view('user.calls.tokenmodify', [
        'settings' => $settings,
        'users' => $this->calls->getUsers(),
        'counters' => $this->calls->getCounters(),
        'pdepartments' => $this->calls->getPDepartments(),
        'departments' => $this->calls->getActiveDepartments(),
        'kiosksetting' => $this->calls->queueSetting(),
        'activedoctors' => $this->calls->getActiveDoctors(),
        'tokendetailbeforecall' => $this->calls->tokenDetailBeforeCalled(),
        'tokendetailbeforecalldoctor' => $this->calls->tokenDetailBeforeCalledDoctor(),
        

    ]);
}
//---------------------------------------------------------
public function rePrintToken(Request $request, $id){
    $request->session()->flash('printFlag', true);
    $queuemodify = Queue::find($request->id);
    $department = Department::findOrFail($queuemodify->department_id);
    $user = Queue::with('user')->find($request->id);
    //---pname-pmobile-pemail---------------
    $pname_p = $queuemodify->pname;
    $pmobile_p = $queuemodify->pmobile;
    $pemail_p = $queuemodify->pemail;
    $pname = ''; $pmobile = ''; $pemail = '';
    if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
    if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
    if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
    //print_r($pname.' '.$pmobile.' '.$pemail); die;
    //-------------------------------------- 
       // event(new \App\Events\TokenIssued());
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', $queuemodify->number);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
        $request->session()->flash('registration_no', $queuemodify->regnumber);
        $request->session()->flash('total', $queuemodify->customer_waiting);
		$request->session()->flash('uhid',  $queuemodify->uhid);
        $request->session()->flash('priority',  $queuemodify->priority);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name); 
       

        
        flash()->success('print');
    return redirect()->route('token_modify');
}

//--------------Doctor-wise-reprint----------------------------

public function rePrintTokenDoctor(Request $request, $id){
    $request->session()->flash('printFlag', true);
    $queuemodify = Queue::find($request->id);
    //---pname-pmobile-pemail---------------
    $pname_p = $queuemodify->pname;
    $pmobile_p = $queuemodify->pmobile;
    $pemail_p = $queuemodify->pemail;
    $pname = ''; $pmobile = ''; $pemail = '';
    if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
    if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
    if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
    //print_r($pname.' '.$pmobile.' '.$pemail); die;
    //-------------------------------------- 
    //$department = Department::findOrFail($queuemodify->department_id);
       $user = User::with('counter','department')->findOrFail($queuemodify->user_id);
       // event(new \App\Events\TokenIssued());
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first(); 
        $request->session()->flash('user_name', $user->name);
        $request->session()->flash('deptname', $user->department->name);
        $request->session()->flash('number', $queuemodify->number);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
       $request->session()->flash('room_number', $user->counter->name);
        $request->session()->flash('registration_no', $queuemodify->regnumber);
        $request->session()->flash('total', $queuemodify->customer_waiting);
		$request->session()->flash('uhid',  $queuemodify->uhid);
        $request->session()->flash('priority',  $queuemodify->priority);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name); 

       

        
        flash()->success('print');
    return redirect()->route('token_modify');
}
//-----------------------------------------------------------
public function modiFicationToken(Request $request, $id){
      $request->session()->flash('printFlag', true);

      $is_uhid_required = $this->isUhidRequired($request->department_id);
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
				flash()->warning('Invalid UHID, only Number');
				return redirect()->route('token_modify');
			}
        }        
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
            $queuemodify = Queue::find($request->id);
            $doctorname = User::with('counter')->findOrFail($queuemodify->user_id);
            $department = Department::findOrFail($queuemodify->department_id);
            $departmentdetail = UhidMaster::where('uhid', $uhid)->first();
            $total = $this->calls->getCustomersWaiting($department, $departmentdetail->priority_type);
            $queuemodify->uhid = $departmentdetail->uhid;
            $queuemodify->customer_waiting = $total; 
            $queuemodify->pname = $pname;
            $queuemodify->pmobile = $pmobile;
            $queuemodify->pemail = $pemail; 
            $queuemodify->priority = $departmentdetail->priority_type;
            $queuemodify->save();    
        $total = $this->calls->getCustomersWaiting($department, $departmentdetail->priority_type);
        $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        //event(new \App\Events\TokenIssued());
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $kiosksetting = $this->calls->queueSetting();
        $request->session()->flash('user_name', $doctorname->name);
        $request->session()->flash('deptname', $department->name);
        $request->session()->flash('room_number', $doctorname->counter->name);
        $request->session()->flash('number', $queuemodify->number);
        $request->session()->flash('total', $total);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
		$request->session()->flash('uhid', $queuemodify->uhid);
        $request->session()->flash('priority', $priority_details['priority_type']);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);
  
    flash()->success('Token Successfully Modify');
    return redirect()->route('token_modify');
              
  }
 //-----------------------------

 public function modiFicationTokenDepartment(Request $request, $id){
    $request->session()->flash('printFlag', true);

    $is_uhid_required = $this->isUhidRequired($request->department_id);
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
              flash()->warning('Invalid UHID, only Number');
              return redirect()->route('token_modify');
          }
      }
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
          $queuemodify = Queue::find($request->id);
          $department = Department::findOrFail($queuemodify->department_id);
          $departmentdetail = UhidMaster::where('uhid', $uhid)->first();
          $total = $this->calls->getCustomersWaiting($department, $departmentdetail->priority_type);
          $queuemodify->uhid = $departmentdetail->uhid;
          $queuemodify->customer_waiting = $total; 
          $queuemodify->pname = $pname;
          $queuemodify->pmobile = $pmobile;
          $queuemodify->pemail = $pemail; 
          $queuemodify->priority = $departmentdetail->priority_type;
          $queuemodify->save();
      $total = $this->calls->getCustomersWaiting($department, $departmentdetail->priority_type);
      $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
      //event(new \App\Events\TokenIssued());
      $staffuser = User::find(Auth::user()->id);
      $stt = Setting::first();
      $kiosksetting = $this->calls->queueSetting();
      $request->session()->flash('department_name', $department->name);
      $request->session()->flash('number', $queuemodify->number);
      $request->session()->flash('total', $total);
      $request->session()->flash('patient_name', $pname);
      $request->session()->flash('patient_mobile', $pmobile);
      $request->session()->flash('patient_email', $pemail);
      $request->session()->flash('uhid', $queuemodify->uhid);
      $request->session()->flash('priority', $priority_details['priority_type']);
      $request->session()->flash('company_name', $stt->name);
      $request->session()->flash('staffname', $staffuser->name);

  flash()->success('Token Successfully Modify');
  return redirect()->route('token_modify');
            
}
  
//-----------------------------------------------------------

    public function newCall(Request $request)
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

        $queue = $this->calls->getNextToken($department);

        if($queue==null) {
            flash()->warning('No Token for this department');
            return redirect()->route('calls');
        }

        $call = $queue->call()->create([
            'pid' => $pdepartment->id,
			'department_id' => $department->id,
            'counter_id' => $counter->id,
            'user_id' => $user->id,
            'number' => $queue->number,
            'called_date' => Carbon::now()->format('Y-m-d'),
        ]);

        $queue->called = 1;
        $queue->save();

        $request->session()->flash('department', $department->id);
        $request->session()->flash('counter', $counter->id);

       // event(new \App\Events\TokenIssued());
        event(new \App\Events\TokenCalled());

        flash()->success('Token Called');
        return redirect()->route('calls');
    }


    public function postDept(Request $request, Department $department)
    {   
		$request->session()->flash('printFlag', true);
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
				return redirect()->route('calls');
			}
        }
        
		//------------
        $todaydate = date('m').substr(date('Y'),2);
        $dublicate = $department->regcode.$todaydate.$request->registration;
        $get_Registration = $this->calls->getRegistNumber($dublicate);
         
        $reqregistration = $request->registration;
	//------------------------------------	
	if($reqregistration == ''){
		$request->session()->flash('printFlag', false);
		flash()->warning('Please Enter 5 digits Only Number');
		return redirect()->route('calls');	
	}
	//-------------------------------------
		$pattern = '~^[0-9]{5}+$~';
		if(!preg_match($pattern, $reqregistration)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
		   return redirect()->route('calls');	 
		}else{
			echo 'yes';
		}
    //---------------------------------------

        if($get_Registration > 0){
            $request->session()->flash('printFlag', false);
            flash()->warning('This Registration Number All Ready Exist');
            return redirect()->route('calls');
        }
      //--------------
      if(!empty($uhid)){
        $uhid_details = UhidMaster::where('uhid', $uhid)->first();
        if(!empty($uhid_details)){
            $priority = $uhid_details['priority_type'];
        }
        
    }   
        //--------Review-Flag-------------------
       $revflag = $request->revflag; $review = '';
       if($revflag == 'R'){
        $review = 'R';
         }else{
        $review = NULL;
         }
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
          $mobilepattern = '~^[0-9]{10}+$~';
		if(!preg_match($mobilepattern, $pmobile_p)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Please Enter Only 10 Digit Mobile Number');
		   return redirect()->route('calls');	 
        } 
        
        $last_token = $this->calls->getLastToken($department);
        $total = $this->calls->getCustomersWaiting($department, $priority);

        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('calls');
            }
            
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => ((int)$last_token->number)+1,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $review,
                'regnumber' => $department->regcode.$todaydate.$request->registration,
                'called' => 0,
                'uhid' => 123,
				'uhid' => $uhid,
                'priority' => $priority,
                'customer_waiting' => $total
            ]);
        } else {
			$tokenNumber = $department->start;
			$istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('calls');
			}
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => $department->start,
                'pname' => $pname,
                'pmobile' => $pmobile,
                'pemail' => $pemail,
                'token_type' => $review,
                'regnumber' => $department->regcode.$todaydate.$request->registration,
                'called' => 0,
                'uhid' => $uhid,
                'priority' => $priority,
                'customer_waiting' => $total
            ]);
        }

        $total = $this->calls->getCustomersWaiting($department, $priority);
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
        $request->session()->flash('registration_no',  $department->regcode.$todaydate.$request->registration);
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.'-'.$queue->number:$queue->number);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
        $request->session()->flash('total', $total-1);
        $request->session()->flash('uhid', $uhid);
        $request->session()->flash('review', $review);
        $request->session()->flash('priority', $priority_details['priority_type']);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);


        flash()->success('Token Added');
        return redirect()->route('calls');
    }


    //--------------Start-token-doctor-wise------------
  public function postDoctor(Request $request)
  {  
      $request->session()->flash('printFlag', true);
      $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
      $user = User::findOrFail($request->user);
      $department = Department::findOrFail($request->department_id);
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
              return redirect()->route('calls');
          }
      }
      
      //---------
      $todaydate = date('m').substr(date('Y'),2); 
      $dublicate = $department->regcode.$todaydate.$request->registration;   
      $get_Registration = $this->calls->getRegistNumber($dublicate);

      $reqregistration = $request->registration;
  //------------------------------------	
  if($reqregistration == ''){
      $request->session()->flash('printFlag', false);
      flash()->warning('Please Enter 5 digits Only Number');
      return redirect()->route('calls');	
  }
  //-------------------------------------
      $pattern = '~^[0-9]{5}+$~';
      if(!preg_match($pattern, $reqregistration)){
         $request->session()->flash('printFlag', false);
         flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
         return redirect()->route('calls');	 
      }else{
          echo 'yes';
      }
  //---------------------------------------
      
          if($get_Registration > 0){
              $request->session()->flash('printFlag', false);
              flash()->warning('This Registration Number All Ready Exist');
              return redirect()->route('calls');
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
      $last_room = $this->calls->getLastRoomNumber($department, $user->pid, $user->id, $array_rooms_id);
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
      $revflag = $request->revflag; $review = '';
      if($revflag == 'R'){
       $review = 'R';
        }else{
       $review = NULL;
        }
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
      $mobilepattern = '~^[0-9]{10}+$~';
      if(!preg_match($mobilepattern, $pmobile_p)){
         $request->session()->flash('printFlag', false);
         flash()->warning('Please Enter Only 10 Digit Mobile Number');
         return redirect()->route('calls');	 
      } 
      


      $last_token = $this->calls->getLastTokenDoctor($department);
      $total = $this->calls->getCustomersWaiting($department, $priority);
     
      
      
      if($last_token) {
          $tokenNumber = ((int)$last_token->number)+1;
          $istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
          if($istkenExist > 0){
              $request->session()->flash('printFlag', false);
              flash()->warning('Token already issued');
              return redirect()->route('calls');
          }
         
      
          $queue = $department->queues()->create([
              'pid' => $user->pid,
              'number' => ((int)$last_token->number)+1,
              'pname' => $pname,
              'pmobile' => $pmobile,
              'pemail' => $pemail,
              'token_type' => $review,
              'regnumber' => $department->regcode.$todaydate.$request->registration,
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
          $istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
          if($istkenExist > 0){
              $request->session()->flash('printFlag', false);
              flash()->warning('Token already issued');
              return redirect()->route('calls');
          }
          $queue = $department->queues()->create([
              'pid' => $user->pid,
              'number' => $department->start,
              'pname' => $pname,
              'pmobile' => $pmobile,
              'pemail' => $pemail,
              'token_type' => $review,
              'regnumber' => $department->regcode.$todaydate.$request->registration,
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
      
      $total = $this->calls->getCustomersWaiting($department, $priority);
      $priority_details = UhidMaster::where('uhid', $request->uhid)->first();

      $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
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

      $request->session()->flash('registration_no',  $department->regcode.$todaydate.$request->registration);
      $request->session()->flash('doctor_department', $department->name);
      $request->session()->flash('user_name', $user->name);
      $request->session()->flash('room_number', $counter->name);
      $request->session()->flash('patient_name', $pname);
      $request->session()->flash('patient_mobile', $pmobile);
      $request->session()->flash('patient_email', $pemail);
      $request->session()->flash('number', ($department->letter!='')?$department->letter.''.$queue->number:$queue->number);
      $request->session()->flash('total', $total-1);
      $request->session()->flash('uhid', $uhid);
      $request->session()->flash('review', $review);
      $request->session()->flash('priority', $priority_details['priority_type']); 
      $request->session()->flash('company_name', $stt->name);
      $request->session()->flash('staffname', $staffuser->name);
      

      flash()->success('Token Added');
      return redirect()->route('calls');
  }

//--------------End-token-doctor-wise--------------


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

    //---------------------------------------------------
    public function getRegistration(Request $request)
    { 
        //$regist = $request->regist;
        $todaydate = date('m').substr(date('Y'),2);
        $department_id = $request->department;
        $regdepartment = Department::find($department_id);
        $regist = $request->registration;
        $inputregnumber = $regdepartment->regcode.$todaydate.$regist;
		$result = Queue::where('regnumber', $inputregnumber)->first();
        $regResult = substr($result->regnumber, -5);
        if(empty($regist)){
            return '';
        }
        
        if(!empty($result)){
			if($result['regnumber'] !== $inputregnumber){
				$output = '<span class="notfbox">Not Found, You Can Create</span>';
			}else{
                $output = '<table class="validregistration">
                           <caption>All Ready Exist</caption>
                           <tr><th>Registration No.</th> <th>Token No.</th> <th>Date/Time</th></tr>
                           <tr><td>'.$result->regnumber.'</td><td>'.$result->number.'</td><td>'.$result->created_at.'</td></tr>
                           </table>' ;
            }
        }
        else{
            $output = '<span class="notfbox">Not Found, You Can Create</span>';
        }
        return $output;
    }
   //-----------------------------------------------------
   public function getRegistrationInDoctor(Request $request)
    { 
        //$regist = $request->regist;
        $todaydate = date('m').substr(date('Y'),2);
        $doctor_id = $request->doctor;
        $doctordept = User::find($doctor_id);
        $regdepartment = Department::find($doctordept->department_id);
        $regist = $request->registration;
        $inputregnumber = $regdepartment->regcode.$todaydate.$regist;
		$result = Queue::with('user','counter')->where('regnumber', $inputregnumber)->first();
        $regResult = substr($result->regnumber, -5);
        if(empty($regist)){
            return '';
        }
        $dctrname = ''; $dctrroom = '';
        if($result->user_id !== NULL){$dctrname = $result->user->name;}else{$dctrname = 'No Doctor';}
        if($result->counter_id !== NULL){$dctrroom = $result->counter->name;}else{$dctrroom = 'No Doctor';}
        
        if(!empty($result)){
			if($result['regnumber'] !== $inputregnumber){
				$output = '<span class="notfbox">Not Found, You Can Create</span>';
			}else{
                $output = '<table class="validregistration">
                           <caption>All Ready Exist</caption>
                           <tr><th>Registration No.</th> <th>Token No.</th> <th>Doctor Name</th> <th>Room No.</th> <th>Date/Time</th></tr>
                           <tr><td>'.$result->regnumber.'</td><td>'.$result->number.'</td><td>'.$dctrname.'</td><td>'.$dctrroom.'</td><td>'.$result->created_at.'</td></tr>
                           </table>' ;
            }
        }
        else{
            $output = '<span class="notfbox">Not Found, You Can Create</span>';
        }
        return $output;
    }


	//-----------------------------------------------------
	
    public function recall(Request $request)
    {
        $call = Call::find($request->call_id);
        $new_call = $call->replicate();
        $new_call->save();

        $call->delete();

        event(new \App\Events\TokenCalled());

        flash()->success('Token Called');
        return $new_call->toJson();
    }
	
	public function postPdept(Request $request)
    { 
		$department = Department::where('pid', $request->pid)->get();
        return $department->toJson();
    }

    public function getPriority(Request $request)
    { 
		$uhid = $request->uid;
		if(empty($uhid)){
			return '';
		}
		$result = UhidMaster::where('uhid', $uhid)->first();
		if(!empty($result)){
			if($result['priority_type'] == 1){
				$output = '<span class="plbox">Platinum</span>';
			}else if($result['priority_type'] == 2){
				$output = '<span class="glbox">Gold</span>';
			}else if($result['priority_type'] == 3){
                $output = '<span class="slbox">Silver</span>';
            }else if($result['priority_type'] == 4){
				$output = '<span class="nlbox">Normal</span>';    
			}else{
				$output = '<span class="erbox">Inavid UHID</span>';
			}
		}else{
			$output = '<span class="erbox">Inavid UHID</span>';
		}
        return $output;
    }

    //--------------------------------------
    public function rePrintTokenDepartmentWise(Request $request, $id){
        $request->session()->flash('printFlag', true);
        $queuemodify = Queue::find($request->id);
        $department = Department::findOrFail($queuemodify->department_id);
            $staffuser = User::find(Auth::user()->id);
            $stt = Setting::first();

            //--------Review-Flag-------------------
      $revflag = $queuemodify->token_type; $review = '';
      if($revflag == 'R'){
        $review = 'R'; }
        elseif($revflag == 'F'){
             $review = 'F';
              }
         else{
        $review = NULL;
         }
            //---pname-pmobile-pemail---------------
      $pname_p = $queuemodify->pname;
      $pmobile_p = $queuemodify->pmobile;
      $pemail_p = $queuemodify->pemail;
      $pname = ''; $pmobile = ''; $pemail = '';
      if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
      if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
      if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
      //print_r($pname.' '.$pmobile.' '.$pemail); die;
      //--------------------------------------
            $request->session()->flash('department_name', $department->name);
            $request->session()->flash('number', $queuemodify->number);
            $request->session()->flash('patient_name', $pname);
            $request->session()->flash('patient_mobile', $pmobile);
            $request->session()->flash('patient_email', $pemail);
            $request->session()->flash('queue_id', $queuemodify->id);
            $request->session()->flash('total', $queuemodify->customer_waiting);
            $request->session()->flash('created_at', $queuemodify->created_at);
            $request->session()->flash('registration_no', $queuemodify->regnumber);
            $request->session()->flash('company_name', $stt->name);
            $request->session()->flash('review', $review);
            $request->session()->flash('staffname', $staffuser->name); 
            
            flash()->success('print');
        return redirect()->route('calls');
    }
//---------------------------------------
    public function rePrintTokenDoctorWise(Request $request, $id){
        $request->session()->flash('printFlag', true);
        $queuemodify = Queue::find($request->id);
        $department = Department::findOrFail($queuemodify->department_id);
        $doctor = User::with('counter')->findOrFail($queuemodify->user_id);
            $staffuser = User::find(Auth::user()->id);
            $stt = Setting::first();

            //--------Review-Flag-------------------
      $revflag = $queuemodify->token_type; $review = '';
      if($revflag == 'R'){
       $review = 'R'; }
       elseif($revflag == 'F'){
            $review = 'F';
             }
        else{
       $review = NULL;
        }
            //---pname-pmobile-pemail---------------
      $pname_p = $queuemodify->pname;
      $pmobile_p = $queuemodify->pmobile;
      $pemail_p = $queuemodify->pemail;
      $pname = ''; $pmobile = ''; $pemail = '';
      if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
      if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
      if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
      //print_r($pname.' '.$pmobile.' '.$pemail); die;
      //--------------------------------------
            $request->session()->flash('user_name', $doctor->name);
            $request->session()->flash('room_number', $doctor->counter->name);
            $request->session()->flash('doctor_department', $department->name);
            $request->session()->flash('number', $queuemodify->number);
            $request->session()->flash('patient_name', $pname);
            $request->session()->flash('patient_mobile', $pmobile);
            $request->session()->flash('patient_email', $pemail);
            $request->session()->flash('total', $queuemodify->customer_waiting);
            $request->session()->flash('queue_id', $queuemodify->id);
            $request->session()->flash('created_at', $queuemodify->created_at);
            $request->session()->flash('registration_no', $queuemodify->regnumber);
            $request->session()->flash('company_name', $stt->name);
            $request->session()->flash('review', $review);
            $request->session()->flash('staffname', $staffuser->name); 
            
            flash()->success('print');
        return redirect()->route('calls');
    }

//--------------------------------------------------------
public function getReviewDoctor(Request $request)
{ 
    $review_id = $request->call_id;
    if(empty($review_id)){
        return '';
    }
    $result = Review::with('user','counter','department')->where('call_id', $review_id)->first();
    $doctor_name = $result->user->name;
    $review_id = $result->call_id;
    $room_no = $result->counter->name;
    $department_name = $result->department->name;
    $last_seen_date = $result->last_seen_date;
    $doctor = $result->user_id;
    $department = $result->department_id;
    $pname = $result->pname;
    $pmobile = $result->pmobile;
    $pemail = $result->pemail;
    $registration = rand(00000 , 99999);
    $revflag = 'R';
    $date_from = $result->last_seen_date;
    $date_to = date('d.m.Y');
    $df = strtotime($date_from);
    $dt = strtotime($date_to);
    $diff = $dt-$df;
    $days = abs(floor($diff/(60*60*24)));
    $exp_day = 7;
    $exp_record = abs($days-$exp_day)+1;
    if(!empty($result)){
        if($days < $exp_day){
        if($result['call_id'] == $review_id){
            $output = '<table class="validregistration reviewverify">
            <input class="pname_'.$doctor.'" name="pname" value="'.$pname.'" type="hidden"  />
            <input class="pmobile_'.$doctor.'" name="pmobile" value="'.$pmobile.'" type="hidden"  />
            <input class="pemail_'.$doctor.'" name="pemail" value="'.$pemail.'" type="hidden"  />
            <input class="revflag_'.$doctor.'" name="revflag" value="'.$revflag.'" type="hidden"  />
            <input class="registration_'.$doctor.'" name="registration" value="'.$registration.'" type="hidden"  />
            <tr><th colspan="6">Your Record Details</th></tr>
            <tr><th>Review ID.</th> <th>Doctor Name</th> <th>Room No.</th> <th>Department</th> <th>Last Seen Date</th><th>&nbsp;</th></tr>
            <tr><td>'.$review_id.'</td><td>'.$doctor_name.'</td><td>'.$room_no.'</td><td>'.$department_name.'</td><td>'.$last_seen_date.'</td><td>'.'<button onclick="queue_doctor('.$doctor.')">Generate Token</button>'.'</td></tr>
            </table>' ;
            
        }else{
            $output = '<span class="notfbox revnoty">Your Record Not Found</span>';
        }

    }else{
        $output = '<span class="notfbox revnoty">Your Review Date Expired '.'<strong>'.$exp_record.' Days'.'</strong>'.' Before from '.'<strong>'.$last_seen_date.'</strong>'.'</span>';
    }

    }else{
        $output = '<span class="erbox">Record Not Found</span>';
    }
    
    return $output;
}


public function getReviewDepartment(Request $request)
{ 
    $review_id = $request->call_id;
    if(empty($review_id)){
        return '';
    }
    $result = Review::with('user','counter','department')->where('call_id', $review_id)->first();
    $doctor_name = $result->user->name;
    $review_id = $result->call_id;
    $room_no = $result->counter->name;
    $department_name = $result->department->name;
    $last_seen_date = $result->last_seen_date;
    $doctor = $result->user_id;
    $department = $result->department_id;
    $pname = $result->pname;
    $pmobile = $result->pmobile;
    $pemail = $result->pemail;
    $registration = rand(88888 , 99999);
    $revflag = 'R';
    $date_from = $result->last_seen_date;
    $date_to = date('d.m.Y');
    $df = strtotime($date_from);
    $dt = strtotime($date_to);
    $diff = $dt-$df;
    $days = abs(floor($diff/(60*60*24)));
    $exp_day = 7;
    $exp_record = abs($days-$exp_day)+1;
    if(!empty($result)){
        if($days < $exp_day){
        if($result['call_id'] == $review_id){
            $output = '<table class="validregistration reviewverify">
           <input class="pname_'.$department.'" name="pname" value="'.$pname.'" type="hidden"  />
           <input class="pmobile_'.$department.'" name="pmobile" value="'.$pmobile.'" type="hidden"  />
            <input class="pemail_'.$department.'" name="pemail" value="'.$pemail.'" type="hidden"  />
            <input class="revflag_'.$department.'" name="revflag" value="'.$revflag.'" type="hidden"  />
            <input class="registration_'.$department.'" name="registration" value="'.$registration.'" type="hidden"  />
            <tr><th colspan="6">Your Record Details</th></tr>
            <tr><th>Review ID.</th> <th>Doctor Name</th> <th>Room No.</th> <th>Department</th> <th>Last Seen Date</th><th>&nbsp;</th></tr>
            <tr><td>'.$review_id.'</td><td>'.$doctor_name.'</td><td>'.$room_no.'</td><td>'.$department_name.'</td><td>'.$last_seen_date.'</td><td>'.'<button onclick="call_dept('.$department.')">Generate Token</button>'.'</td></tr>
            </table>' ;
            
        }else{
            $output = '<span class="notfbox revnoty">Your Record Not Found</span>';
        }
    }else{
        $output = '<span class="notfbox revnoty">Your Review Date Expired '.'<strong>'.$exp_record.' Days'.'</strong>'.' Before from '.'<strong>'.$last_seen_date.'</strong>'.'</span>';
    }

    }else{
        $output = '<span class="erbox">Record Not Found</span>';
    }
    
    return $output;
}
//--------------------------------------------------------    





}
