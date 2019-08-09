<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\Call;
use App\Models\User;
use App\Models\Ad;
use App\Models\DisplaySetting;
use Carbon\Carbon;
use App\Models\ParentDepartment;

class Display2Repository
{
    public function getSettings()
    {
        return Setting::first();
	}
	
	public function getDisplaySetting(){
		return DisplaySetting::first();
	}

    public function getDisplayData()
    {   
        $calls = Call::with('department', 'counter', 'user', 'ads')
					->where('called_date', Carbon::now()->format('Y-m-d'))
					->where('doctor_work_end', 0)
                    ->orderBy('id', 'desc')
                    //->take(4)
                    ->get();
		//return $calls;
        $data = [];
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
			$data[$cls->user_id][] = [
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
		if(!empty($data)){
			foreach($data as $dt){
				$filter_arr = array_merge($filter_arr, array_chunk($dt, 6));
			}
		}
		$final_arr = [];
		if(!empty($filter_arr))
		{
			$final_arr = array_chunk($filter_arr, 1);
		}
		
		return $final_arr;
			
		/*
        for ($i=0;$i<4;$i++) {
            $data[$i]['call_id'] = (isset($calls[$i]))?$calls[$i]->id:'NIL';
            $data[$i]['number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.'-'.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['call_number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.' '.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['counter'] = (isset($calls[$i]))?$calls[$i]->counter->name:'NIL';
        }
		*/
       // return $data;
	}
	
	public function getLastCallId()
	{
		$calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
					->where('doctor_work_end', 0)
                    ->orderBy('id', 'desc')
					->first();
	    if(!empty($calls)){
			return $calls->id;
		}else{
			return '';
		}			
	}

	public function getAudioCallId()
	{
		$calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
					->where('doctor_work_end', 0)
                    ->orderBy('id', 'asc')
					->first();
	    if(!empty($calls)){
			return $calls->id;
		}else{
			return '';
		}			
	}

	public function getCurrentCallDetails($id)
	{
		$calls = Call::with('department', 'counter')
		->where('called_date', Carbon::now()->format('Y-m-d'))
		->where('id', $id)
		->first();
		return $calls;
	}
	

	public function getNextCallId($id)
	{
		$calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
					->where('doctor_work_end', 0)
					->where('id', '>', $id)
                    ->orderBy('id', 'asc')
					->first();
	    if(!empty($calls)){
			return $calls->id;
		}else{
			return 'NOID';
		}	
	}
}
