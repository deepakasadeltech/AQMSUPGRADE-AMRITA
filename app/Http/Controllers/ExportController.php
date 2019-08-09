<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DisplayRepository;
use App\Repositories\DoctorReportRepository;
use App\Models\DoctorReport;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;



use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{
    protected $displays;

    public function __construct(DoctorReportRepository $displays)
    {
        $this->displays = $displays;
    }

    public function index()
    {
		$calls = DoctorReport::all()
                   ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'));
                    
        $headers = array("S.No", "User ID", "Doctor Name", "Room Number", "Room ID", "Deprtment", "Token Number", "Start Time", "End Time");
		$fp = fopen('D:\Axamp\htdocs\aqmsv1\assets\files\doctor_list.csv', 'wb');
		fputcsv($fp, $headers);
		$counter = 1;
		foreach($calls as $cls){
			$user = User::with('counter')->find($cls->user_id);
			$department = Department::find($cls->department_id);
			$row = [
			$counter, 
			$user->id, 
			$user->name, 
			$user->counter->name,
			$user->counter->id,
			$department->name, 
			$cls->token_number,
			$cls->start_time, 
			$cls->end_time
			];
			fputcsv($fp, $row);
			$counter++;
			
		}
		fclose($fp);
		exit("Csv Generated at : assets/files/doctor_list.csv");
    }
	
	
}
