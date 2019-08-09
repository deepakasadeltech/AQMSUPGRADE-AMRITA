<?php

namespace App\Listeners;

use App\Events\CsvGenerate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\Call;
use App\Models\ParentDepartment;
use App\Models\DoctorReport;
use App\Models\User;
use App\Models\Counter;
use App\Models\Department;
use Carbon\Carbon;
use DB;

class CsvFileUpdate
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

    public function handle(CsvGenerate $event)
    {
        $fp = fopen('C:\Token Display\token.txt', 'wb');
        $rooms = Counter::all();
        foreach($rooms as $room){

            $calls = Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                                //->where('user_id', Auth::user()->id)
                                ->where('view_status', 1)
                                ->where('counter_id', $room->id)
                                ->orderBy('id', 'desc')
                                ->first();

            if(!empty($calls)){
               // $txt = $room->id . $calls->number . "\r\n";
                $txt = $calls->number . "\r\n";
            }else{
                //$txt = $room->id . "0000\r\n";
                $txt = "0000\r\n";
            }                    
             fwrite($fp, $txt);
        }
        fclose($fp);
    }

	
}
