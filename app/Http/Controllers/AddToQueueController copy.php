<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AddToQueueRepository;
use App\Models\Setting;
use App\Models\Department;
use App\Models\User;
use App\Models\Counter;
use App\Models\QueueSetting;
use App\Models\ParentDepartment;
use App\Models\UhidMaster;
use App\Models\Review;
use App\Models\Call;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class AddToQueueController extends Controller
{
    protected $add_to_queues;

    public function __construct(AddToQueueRepository $add_to_queues)
    {
        $this->add_to_queues = $add_to_queues;
    }

    public function index(Request $request)
    {
        $settings = Setting::first();
       // $kiosksetting = QueueSetting::first();

        \App::setLocale($settings->language->code);
        return view('addtoqueue.index', [
            'settings' => $settings,
            'kiosksetting' => $this->add_to_queues->queueSetting(),
            'departments' => $this->add_to_queues->getActiveDepartments(),
            'activedoctors' => $this->add_to_queues->getActiveDoctors(),
            'getpdepartments' => $this->add_to_queues->getPdepartments(),
            'doctorreports' => $this->add_to_queues->doctorreports(),	
            'userdoctordetails' => $this->add_to_queues->getUserDoctorName(),
            'getdepartmentbydoctors' => $this->add_to_queues->getDepartmentByDoctor(),			
        ]);

       // print_r($pdepartments);
    }

    public function refreshToken()
    {
        $departments = $this->add_to_queues->getActiveDepartments();
        $html = '';
        foreach($departments as $department){
            if( $department->is_uhid_required == 1){
                $html .='<a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_'.$department->id.'">'.$department->name.'<sup style="color:#890202; font-size:15px">*</sup></a>';
            }else{
                $html .='<button style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="btn waves-effect waves-light csfloat" onclick="queue_dept('.$department->id.')" style="text-transform:none">'.$department->name.'</button>';
            }
        }

        return $html;
    }

    public function postDept(Request $request)
    {  
        $request->session()->flash('printFlag', true);
        $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        $department = Department::findOrFail($request->department);
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
				return redirect()->route('add_to_queue');
			}
		}
        
        //---------
        $todaydate = date('m').substr(date('Y'),2); 
        $dublicate = $department->regcode.$todaydate.$request->registration;   
        $get_Registration = $this->add_to_queues->getRegistNumber($dublicate);

		$reqregistration = $request->registration;
	//------------------------------------	
	if($reqregistration == ''){
		$request->session()->flash('printFlag', false);
		flash()->warning('Please Enter 5 digits Only Number');
		return redirect()->route('add_to_queue');	
	}
	//-------------------------------------
		$pattern = '~^[0-9]{5}+$~';
		if(!preg_match($pattern, $reqregistration)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
		   return redirect()->route('add_to_queue');	 
		}else{
			echo 'yes';
		}
    //---------------------------------------
        
            if($get_Registration > 0){
                $request->session()->flash('printFlag', false);
                flash()->warning('This Registration Number All Ready Exist');
                return redirect()->route('add_to_queue');
            }
        //------------

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
		   return redirect()->route('add_to_queue');	 
		} 
        
        $last_token = $this->add_to_queues->getLastToken($department);
		$total = $this->add_to_queues->getCustomersWaiting($department, $priority);

        
        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->add_to_queues->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('add_to_queue');
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
                'uhid' => $uhid,
                'priority' => $priority,
                'customer_waiting' => $total,
            ]);
        } else {
			$tokenNumber = $department->start;
			$istkenExist = $this->add_to_queues->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('add_to_queue');
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

        
        $total = $this->add_to_queues->getCustomersWaiting($department, $priority);
		$priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        //event(new \App\Events\TokenIssued());

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
        $request->session()->flash('number', ($department->letter!='')?$department->letter.''.$queue->number:$queue->number);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
        $request->session()->flash('total', $total);
        $request->session()->flash('uhid', $uhid);
        $request->session()->flash('review', $review);
        $request->session()->flash('priority', $priority_details['priority_type']);

        flash()->success('Token Added');
        return redirect()->route('add_to_queue');
    }


  //--------------Start-token-doctor-wise------------


  public function postDoctor(Request $request)
    {  
        $request->session()->flash('printFlag', true);
        $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        $user = User::findOrFail($request->user);
        $counter = User::with('counter')->findorFail($user->id);
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
				return redirect()->route('add_to_queue');
			}
		}
        
        //---------
        $todaydate = date('m').substr(date('Y'),2); 
        $dublicate = $department->regcode.$todaydate.$request->registration;   
        $get_Registration = $this->add_to_queues->getRegistNumber($dublicate);

		$reqregistration = $request->registration;
	//------------------------------------	
	if($reqregistration == ''){
		$request->session()->flash('printFlag', false);
		flash()->warning('Please Enter 5 digits Only Number');
		return redirect()->route('add_to_queue');	
	}
	//-------------------------------------
		$pattern = '~^[0-9]{5}+$~';
		if(!preg_match($pattern, $reqregistration)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
		   return redirect()->route('add_to_queue');	 
		}else{
			echo 'yes';
		}
    //---------------------------------------
        
            if($get_Registration > 0){
                $request->session()->flash('printFlag', false);
                flash()->warning('This Registration Number All Ready Exist');
                return redirect()->route('add_to_queue');
            }
        //------------

        if(!empty($uhid)){
			$uhid_details = UhidMaster::where('uhid', $uhid)->first();
			if(!empty($uhid_details)){
				$priority = $uhid_details['priority_type'];
			}
			
        }

         //--------doctor-multiroom-----------------------
     $doctroom = ''; $counter = '';
     /*if(!empty($user->counter_id)){ 
         $rooms_id = $user->counter_id;
        $array_rooms_id =  explode(', ', $rooms_id); 
        $rand_room = array_rand($array_rooms_id);
        $doctroom = $array_rooms_id[$rand_room]; 
        $counter = Counter::where('id', $doctroom)->first();
     }else{$doctroom = 'No room';}*/
       //--------Review-Flag-------------------
       $revflag = $request->revflag; $review = '';
       if($revflag == 'R'){
        $review = 'R';
         }else{
        $review = NULL;
         }
       // print_r($background); die;
        
       $rooms_id = $user->counter_id; $check = '';
       $array_rooms_id =  explode(', ', $rooms_id); 
       $rand_room = array_rand($array_rooms_id);
        $ddroom = $array_rooms_id[$rand_room];

       $last_room = $this->add_to_queues->getLastRoomNumber($department, $user->pid, $user->id, $array_rooms_id);
       $current = current($array_rooms_id);
        $next = next($array_rooms_id);
        $end = end($array_rooms_id);
        $index = 1;

        /*
        if(!empty($last_room->counter_id)){ 
      //--------------------------------------
        if($last_room->counter_id == $current){
            //$doctroom = $last_room->counter_id+$index;
            $doctroom = $next;
          
           } 
        
        if($last_room->counter_id == $next){
            if(count($array_rooms_id) > 2){
            $doctroom = ($last_room->counter_id)+1; 
            echo $check = 'Next_3- '.$next;  
        }else{
            $doctroom = $current;
        } 
         
         }
        
        if($last_room->counter_id == $end){
            $doctroom = $current; 
           // echo $check = 'Next_2- '.$end;  
        } 
        
      //--------------------------->  

        }else{
            $doctroom = $current;
        }
        
        $counter = Counter::where('id', $doctroom)->where('pid', $user->pid)->where('department_id', $user->department_id)->first();
        */


    //-------------------------------------    
        $cnt = 1; $ddrrm='';
        //echo '<br>'.count($array_rooms_id).'<br><br><br><br>';
        $rmvar = ''; $rmnext = '';
        if(!empty($last_room->counter_id)){ 
            if($last_room->counter_id == $current){
                $doctroom = $array_rooms_id[1];
            }
          for($i=0; $i < count($array_rooms_id); $i++){
            
            if($last_room->counter_id == $next){
                for($k=1; $k < 4; $k++){
                if($last_room->counter_id == $array_rooms_id[$i+$k]){
                    $doctroom = ($i+$k).'-'.$array_rooms_id[$i+$k];
                }

                }
            } 

          }
          if($last_room->counter_id == $end){
            $doctroom = $array_rooms_id[0];
        }

        }else{
            $doctroom = $current;
        }

        $counter = Counter::where('id', $doctroom)->where('pid', $user->pid)->where('department_id', $user->department_id)->first();
          echo $ddrrm.'<br><br>'; 
          echo $rmnext.'<br><br>'; 
       //----------------------------------------   

        echo  '<br>'.$doctroom;
        //echo $counter->name;
         die;

     
        
        //---pname-pmobile-pemail---------------
      $pname_p = $request->pname;
      $pmobile_p = $request->pmobile;
      $pemail_p = $request->pemail;
      $mobilepattern = '~^[0-9]{10}+$~';
		if(!preg_match($mobilepattern, $pmobile_p)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Please Enter Only 10 Digit Mobile Number');
		   return redirect()->route('add_to_queue');	 
		} 
      $pname = ''; $pmobile = ''; $pemail = '';
      if($pname_p !== ''){$pname = $pname_p;}else{$pname = NULL;}
      if($pmobile_p !== ''){$pmobile = $pmobile_p;}else{$pmobile = NULL;}
      if($pemail_p !== ''){$pemail = $pemail_p;}else{$pemail = NULL;}
      //print_r($pname.' '.$pmobile.' '.$pemail); die;
      //--------------------------------------
     
        
        $last_token = $this->add_to_queues->getLastTokenDoctor($department);
		$total = $this->add_to_queues->getCustomersWaiting($department, $priority);
       
        
        
        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->add_to_queues->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('add_to_queue');
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
			$istkenExist = $this->add_to_queues->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('add_to_queue');
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
 
        $total = $this->add_to_queues->getCustomersWaiting($department, $priority);
		$priority_details = UhidMaster::where('uhid', $request->uhid)->first();
       // event(new \App\Events\TokenIssued());
        $settings = Setting::first();
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
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('user_name', $user->name);
        $request->session()->flash('room_number', $counter->name);
        $request->session()->flash('patient_name', $pname);
        $request->session()->flash('patient_mobile', $pmobile);
        $request->session()->flash('patient_email', $pemail);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.''.$queue->number:$queue->number);
        $request->session()->flash('total', $total);
        $request->session()->flash('uhid', $uhid);
        $request->session()->flash('review', $review);
        $request->session()->flash('priority', $priority_details['priority_type']); 

        flash()->success('Token Added');
        return redirect()->route('add_to_queue');
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

    public function getRegistration(Request $request)
    { 
        //$regist = $request->regist;
		$regist = $request->registration;
		$result = Queue::first();
		$regResult = substr($result->regnumber, 6);
		
			if($regResult !== $regist){
				$output = '<span class="plbox">Valid</span>';
			}else{
                $output = 'Invalid';
            }
		
        return $output;
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
            <tr><td>'.$review_id.'</td><td>'.$doctor_name.'</td><td>'.$room_no.'</td><td>'.$department_name.'</td><td>'.$last_seen_date.'</td><td>'.'<button onclick="queue_dept('.$department.')">Generate Token</button>'.'</td></tr>
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
