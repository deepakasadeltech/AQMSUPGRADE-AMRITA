<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Display2Repository;

class Display2Controller extends Controller
{
    protected $displays;

    public function __construct(Display2Repository $displays)
    {
        $this->displays = $displays;
    }

    public function index()
    {
        $settings = $this->displays->getSettings();
        $displaysetting = $this->displays->getDisplaySetting();

        \App::setLocale($settings->language->code);

        event(new \App\Events\TokenCalled2());

        return view('displaysecond.index', [
            'data' => $this->displays->getDisplayData(),
            'audio_call_id' => $this->displays->getAudioCallId(),
            'last_id' => $this->displays->getLastCallId(),
            'settings' => $settings,
            'displaysetting' => $displaysetting,
        ]);
    }
	
	public function test()
	{
		$data = $this->displays->getAudioCallId();
		echo "<pre>";
		print_r($data);die;
    }
    
    public function autoCall(Request $request)
    {
        $call_id = $request->audio_id;
        $last_id = $request->audio_last_id;
        $currentlastId = $this->displays->getLastCallId();
        $cls = $this->displays->getCurrentCallDetails($call_id);
        if(!empty($cls))
        {
            $nextid = $this->displays->getNextCallId($call_id);
            $play = "PLAY";
            if($currentlastId != $last_id){
                $play = "NOTPLAY";
                $id1 = $call_id;
                $id2 = $currentlastId;
            }else{
                $play = "PLAY";
                if($nextid == 'NOID'){
                    $id1 = $this->displays->getAudioCallId();     
                    $id2 = $this->displays->getLastCallId();
                }else{
                    $id1 =$nextid; 
                    $id2 = $last_id;  
                }
                
            }
            $call_number = $cls->department->letter.' '.$cls->number;
            $counter = $cls->counter->name;
            $str = $play.'@'.$call_number.'@'.$counter.'@'.$id1.'@'.$id2;
        }else{
            $str = 'NOTPLAY@NA@NA@'.$call_id.'@'.$last_id;
        }
        
        return $str;
    }

}
