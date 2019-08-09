<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DisplaySettingRepository;
use App\Models\DisplaySetting;
use Carbon\Carbon;

class DisplaySettingController extends Controller
{
    protected $displaysettings;

    public function __construct(DisplaySettingRepository $displaysettings)
    {
        $this->displaysettings = $displaysettings;
    }

    public function index(Request $request)
    {
        $this->authorize('access', DisplaySetting::class);
        return view('user.displaysetting.index', [
            'displaysetting' => $this->displaysettings->getDisplaySettings(),
        ]);
		
    }
//---------------------

public function displayTextUpdate(Request $request)
    {  //$this->authorize('access', DisplaySetting::class);
         $this->validate($request, [
            'textup' => 'bail|required',
            'textdown' => 'bail|required',
            'deptflag' => 'required',
            'deptcflag' => 'required',
            'doctorflag' => 'required',
            'work' => 'required',
            'columnflag' => 'required',
            ]);
        $displaysetting = $this->displaysettings->getDisplaySettings();
        $displaysetting->textup = $request->textup;
        $displaysetting->textdown = $request->textdown;
        $displaysetting->deptflag = $request->deptflag;
        $displaysetting->deptcflag = $request->deptcflag;
        $displaysetting->doctorflag = $request->doctorflag;
        $displaysetting->work = $request->work;
        $displaysetting->columnflag = $request->columnflag;
        $displaysetting->save();
         flash()->success('Display Text updated');
        return redirect()->route('displaysettings.index');
    }
//-------------------------

public function displayBgUpdate(Request $request)
    {   //$this->authorize('access', DisplaySetting::class);
        $this->validate($request, [
            'bgimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
         if ($request->hasFile('bgimg')) {
            $image = $request->file('bgimg');
            $name = time().'.'.$image->getClientOriginalExtension(); 
            $destinationPath = public_path('/displaysetting');
            $image->move($destinationPath, $name);
        }else{
            $name = $request->bgimg;
        }
        $displaysetting = $this->displaysettings->getDisplaySettings();
        $displaysetting->bgimg = $name;
        $displaysetting->save();
        flash()->success('Display Background Image updated');
        return redirect()->route('displaysettings.index');
    }
//----------------------------

public function displayVideoUpdate(Request $request)
    {     //$this->authorize('access', DisplaySetting::class);
         $this->validate($request, [
            'video' =>'required|mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040',
            ]);

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $vname = time().'.'.$video->getClientOriginalExtension();
            $vdestinationPath = public_path('/displaysetting');
            $video->move($vdestinationPath, $vname);
        }else{
            $vname = $request->video;
        }
        $displaysetting = $this->displaysettings->getDisplaySettings();
        $displaysetting->video = $vname;
        $displaysetting->save();

        flash()->success('Display Video updated');
        return redirect()->route('displaysettings.index');
    }




//-----------------------

}
