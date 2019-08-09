<?php

namespace App\Listeners;

use App\Events\TokenCalled2;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Call;
use App\Models\Setting;
use App\Models\Ad;
use App\Models\DisplaySetting;
use App\Models\ParentDepartment;
use Carbon\Carbon;

class UpdateDisplay2
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(TokenCalled2 $event)
	{   $welcome = Setting::first();
		$displaysetting = DisplaySetting::first();
        $calls = Call::with('department', 'counter', 'ads')
					->where('called_date', Carbon::now()->format('Y-m-d'))
					->where('doctor_work_end', 0)
                    ->orderBy('calls.id', 'desc')
                    //->take(4)
                    ->get();

		$day = date("l"); 
		$time = \Carbon\Carbon::now()->format('h:i A');	
		$date = date("d.m.Y");
	    date_default_timezone_set('Asia/Calcutta');$h = date('H'); $a = $h >= 12 ? 'PM' : 'AM'; 
		$timestamp = date('h:i:s ').$a;
		
        $data = [];
        for ($i=0;$i<1;$i++) {
            $data[$i]['call_id'] = (isset($calls[$i]))?$calls[$i]->id:'NIL';
            $data[$i]['number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.''.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['call_number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.' '.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['counter'] = (isset($calls[$i]))?$calls[$i]->counter->name:'NIL';
			$data[$i]['pid'] = (isset($calls[$i]))?$calls[$i]->pid:'NIL';
			$data[$i]['department_id'] = (isset($calls[$i]))?$calls[$i]->department_id:'NIL';
        }
		$data2 = [];
		foreach($calls as $cls)
		{
			$call_id = $cls->id;
			$call_number = $cls->department->letter.''.$cls->number;
			$counter = $cls->counter->name;
			$dep_id = $cls->pid;
			$dep_details = ParentDepartment::find($cls->pid);
			$dep = $dep_details->name;
			$sub_dep_id = $cls->department_id;
			$sub_dep = $cls->department->name;
			$sub_dep_olangname = $cls->department->olangname;
			$doctor_name = $cls->user->name;
			$doctor_profile = $cls->user->profile;
			$doctor_photo = $cls->user->photo;
			$view_status = $cls->view_status;
			$ads_img = $cls->ads->adimg;
			$data2[$cls->user_id][] = [
											'call_id'=>$call_id,
											'call_number'=>$call_number,
											'counter'=>$counter,
											'dep_id'=>$dep_id,
											'dep'=>$dep,
											'sub_dep_id'=>$sub_dep_id,
											'sub_dep'=>$sub_dep,
											'sub_dep_olangname' =>$sub_dep_olangname,
											'doctor_name' =>$doctor_name,
											'doctor_profile' =>$doctor_profile,
											'doctor_photo' =>$doctor_photo,
											'view_status'=>$view_status,
											'ads_img'=>$ads_img
			];
			
		}


		$filter_arr = [];
		if(!empty($data2)){
			foreach($data2 as $dt){
				$filter_arr = array_merge($filter_arr, array_chunk($dt, 6));
			}
		}
		$final_arr = [];
		if(!empty($filter_arr))
		{
			$final_arr = array_chunk($filter_arr, 1);
		}
		
		if(!empty($final_arr))
		{
			$html ='<div class="slider"><ul class="slides">';
			foreach($final_arr as $d1)
			{
				$html .='<li>';
				foreach($d1 as $d2)
				{
			//----------------------------------
			$heading = '';
			if($displaysetting->deptflag==1){ $heading = $d2[0]['sub_dep'];
			}elseif($displaysetting->deptflag==2){if(!empty($d2[0]['sub_dep_olangname'])){ $heading = $d2[0]['sub_dep_olangname'];}
			}elseif($displaysetting->deptflag==3){
			$heading = $d2[0]['sub_dep'].'- '.$d2[0]['sub_dep_olangname']; 
			}else{ $heading = 'No Department';} 
		   //------------------------------------
		   $column = '';
			if($displaysetting->columnflag==1)
			$column = '<th>'.trans('messages.display.department').'</th>';
			elseif($displaysetting->columnflag==2)
			$column = '<th>'.trans('messages.display.doctor').'</th>';
			elseif($displaysetting->columnflag==3)
			$column = '<th>'.trans('messages.display.department').'</th>'.''.'<th>'.trans('messages.display.doctor').'</th>';
			else{ $column = '';}
			//------------------------------------
			if($d2[0]['doctor_photo'] !== NULL) {
				$doctpic = "<div class='doctorpbox'><img src='".url('public/doctorimg').'/'.$d2[0]['doctor_photo']."' alt='User Photo'></div>";
			    }else{ 
				$doctpic = "<div class='doctorpbox'><img src='".url('public/doctorimg').'/'.'avatar.jpg'."' alt='User Photo'></div>"; }

			//---------------------------------
					$html .='<div class="boxrow2" class="caption right-align">';
				//------------first-row-logo-time-------------
					$html .='<div class="row rowbg" style="margin-bottom:0px;">';
					
					$html .='<div class="col s8" style="padding:0px;"> ';
					$html .='<div style="display:none;" class="cstring">'.$welcome->name.'</div>';
                    $html .='<div class="queuelogo displaylogo">';
					$html .="<span><img src='".url('public/logo').'/'. $welcome->logo."' alt='logo'></span> <span class='amritahosp'>".$welcome->name."</span>";
			        $html .='</div>';
					$html .='</div>';

					$html .='<div class="col s4" style="padding:0px;"> ';
                    $html .='<h1 class="display3heading">'.''.'<span class="displaytime displaytime2"><span>'.$date.'</span> <span class="timestamp">' .$timestamp. '</span> </span></h1>';
					$html .='</div>';
					
					$html .='</div>';
	
			 //------second-row------------------------
			        $html .='<div class="row" style="margin-bottom:0px;">';	
					$html .='<div class="col s2" style="padding:10px 5px 10px 10px;">';
					$html .='<div class="doctordetaildisplaybox">';
					$html .= "$doctpic";
					$html .='<h1>'.substr($d2[0]['doctor_name'], 0, 20).'</h1>';
					$html .='<h3>'.'( '.substr($d2[0]['doctor_profile'], 0, 20).' )'.'</h3>';
					$html .='<h2>'.substr($d2[0]['sub_dep'], 0, 11).'</h2>';
					$html .='<h2>'.substr($d2[0]['counter'], 0, 11).'</h2>';
					$html .='</div>';
					$html .='</div>';
				  //---------start-adv-img-----
				  $html .='<div class="col s6" style="padding:10px 0px 10px 5px;">';
				  $html .='<div class="advertisedisplay">';
				if($d2[0]['ads_img'] !== NULL){
				  $html .="<img src=".url('public/adsimg').'/'.$d2[0]['ads_img']." alt='adv image'>"; 
			    }else{ 
				$html .="<img src=".url('public/adsimg').'/'.'avatar.jpg'." alt='Default Image'>"; }
				 $html .='</div>';
				 $html .='</div>';
			   
				   //------End-adv-img----------
					$html .='<div class="col s4" style="padding:0 5px;">';
					$html .='<table>';
					$html .='<thead>';
					$html .= '<tr>';
					$html .= '<th><span class="spth">'.trans('messages.display.dtoken').'</span></td>';
					$html .= '<th><span class="spth">'.trans('messages.display.roomnumber').'</span></td>';
					$html .= '</tr>';
					$html .='</thead>';
					$html .='<tbody>';
					foreach($d2 as $d3) {
						$blinking = '';
						if($d3['view_status'] == 1) { 
							$blinking = 'patcurrentstatus';
						}else{
							$blinking = 'patcurrentstatusb';
						}
					   //------------------------------
					$depart_name = ''; $doctr_name = ''; $deptcolumn = ''; $doctorcolumn = '';
					$columnbox = '';
					if($displaysetting->deptcflag==1){ $depart_name = $d3['sub_dep'];}elseif($displaysetting->deptcflag==2){if(!empty($d3['sub_dep_olangname'])){ $depart_name = $d3['sub_dep_olangname'];}
					}elseif($displaysetting->deptcflag==3){ $depart_name = $d3['sub_dep'].'- '.$d3['sub_dep_olangname'];}else{ $depart_name = 'No Department';}
					   
				   
					   //-------------------------------
						$html .='<tr>';
						$html .='<td id=""><span class="sptd">'.'<span class="'.$blinking.'"></span>'.$d3['call_number'].'</span></td>';
						$html .='<td id=""><span class="sptd">'.$d3['counter'].'</span></td>';
						$html .='</tr>';
		
					}
					$html .='</tbody>';
					$html .='</table>';
					 
					$html .='</div>';
					$html .='</div>';

					$html .="</div>";
				}
				$html .= '</li>';
			}
			$html .= '</ul></div>';

			$html .= '<div id="notitext" class="row"></div>';
		 $html .= "<div class='infobox'><span class='esiclogo'><img src='".url(url('public/logo').'/'.$welcome->logo)."' ></span><div id='notitext' class='notitext'> <marquee>".$welcome->notification."</marquee> </div><span class='mylogo'>Powered By :<strong> ASADEL TECHNOLOGIES (P) LTD</strong></span></div>";
			$data[1]['html'] = $html;
		}else{
			date_default_timezone_set('Asia/Kolkata'); 
			$dt = date("d.m.Y");
			$html ='<div class="slider"><ul class="slides">';
			$html .='<li> <div class="datetimeglobal_time"><span>'.$displaysetting->textup.'</span><span>'.$displaysetting->textdown.'</span><span>'.$dt.'</span><span>' .$dt . '</span>
			<span class="gtime">' .$timestamp. '</span></div></li>';
			$html .="<li><div class='datetimeglobal_time' style='background:url(url('public/displaysetting').'/'.$displaysetting->bgimg) no-repeat center; background-size:cover;'><video autoplay loop muted=''>
              <source src='".url('public/displaysetting').'/'.$displaysetting->video."' type='video/webm'>
              <source src='".url('public/displaysetting').'/'.$displaysetting->video."' type='video/mp4'>
            </video> </div></li>";
			$html .='</ul></div>';
			$html .= '<div id="notitext" class="row"></div>';
		 $html .= "<div class='infobox'><span class='esiclogo'><img src='url(url('public/logo').'/'.$welcome->logo)' ></span><div id='notitext' class='notitext'> <marquee>".$welcome->notification."</marquee> </div><span class='mylogo'>Powered By :<strong> ASADEL TECHNOLOGIES (P) LTD</strong></span></div>";
			$data[1]['html'] = $html;
		}
		

        file_put_contents(base_path('assets/files/display2'), json_encode($data));
    }
}
