<?php

namespace App\Repositories;
use App\Models\User;
use App\Models\Department;
use App\Models\Counter;
use App\Models\QueueSetting;
use App\Models\ParentDepartment;
use App\Models\DoctorReport;
use Carbon\Carbon;
use App\Models\Queue;
use App\Models\Review;
use App\Models\Call;


class AddToQueueRepository
{
    public function getDepartments()
    {
        return Department::all();
    }

    public function queueSetting(){
       return QueueSetting::first();
    }

    public function getActiveDepartments()
    { 
      $depid = User::all()->where('user_status', '1');
       
        $ids = [];
        foreach($depid as $id){
            if(!empty($id->department_id)){
                $ids[$id->department_id] = $id->department_id;
            }
        }
        return Department::whereIn('id', $ids)->get();
    }

    public function getActiveDoctors()
    { 
      return User::with('department')->where('user_status', '1')->where('role','D')->where('counter_id', '!=', '')->orderBy('department_id')->get();
       
       
    }
    
	public function getPdepartments()
    {
        return ParentDepartment::all();
    }

    public function doctorreports()
    {
        return DoctorReport::all();
    }

    public function getDepartmentByDoctor()
    {
        return User::with('department', 'counter') 
                   ->where('role', 'D')
                   ->where('user_status', '1')
                   ->get();
    }

    public function getUserDoctorName()
    {
        return User::with('department', 'counter') 
                   ->where('role', 'D')
                   ->get();
    }

    public function getLastToken(Department $department)
    {
        return $department->queues()
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('number', 'desc')
                    ->first();
    }

    public function getLastRoomNumber(Department $department, $pid='', $doctor_id = '', $counter_id = '')
    {
        return Queue::where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->where('pid', $pid)
                    ->where('user_id', $doctor_id)
                    ->orderBy('number', 'desc')
                    ->whereIn('counter_id', $counter_id)
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
	
	public function isTokenExist($pid, $department_id, $token)
    {
        return Queue::where('pid', $pid)
                    ->where('department_id', $department_id)
                    ->where('number', $token)
					->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->count();
    }

    
}
