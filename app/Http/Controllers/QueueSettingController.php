<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QueueSettingRepository;
use App\Models\QueueSetting;

class QueueSettingController extends Controller
{
    protected $queuesettings;

    public function __construct(QueueSettingRepository $queuesettings)
    {
        $this->queuesettings = $queuesettings;
    }

    public function index(Request $request)
    {
        $this->authorize('access', QueueSetting::class);
        return view('user.queuesetting.index', [
            'kiosksetting' => $this->queuesettings->getKioskSettings(),
        ]);
		
    }
//-----------------------------
    public function kioskTextUpdate(Request $request)
    {
        //$this->authorize('access', DisplaySetting::class);

        $this->validate($request, [
            'texteng' => 'bail|required',
            'textotherlang' => 'bail|required',
            'deptflag' => 'bail|required',
            'reg_required' => 'bail|required',
            'tokendisplay' => 'bail|required',
            'dr_tokenstyle' => 'bail|required',
        ]);

        $kiosksetting = $this->queuesettings->getKioskSettings();
        $kiosksetting->texteng = $request->texteng;
        $kiosksetting->textotherlang = $request->textotherlang;
        $kiosksetting->deptflag = $request->deptflag;
        $kiosksetting->reg_required = $request->reg_required;
        $kiosksetting->tokendisplay = $request->tokendisplay;
        $kiosksetting->dr_tokenstyle = $request->dr_tokenstyle;
        $kiosksetting->save();

        flash()->success('Kiosk Setting updated');
        return redirect()->route('queuesettings.index');
    }
//-----------------------
public function kioskBgUpdate(Request $request)
    {   //$this->authorize('access', DisplaySetting::class);
        $this->validate($request, [
            'bgimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
         if ($request->hasFile('bgimg')) {
            $image = $request->file('bgimg');
            $name = time().'.'.$image->getClientOriginalExtension(); 
            $destinationPath = public_path('/kiosksetting');
            $image->move($destinationPath, $name);
        }else{
            $name = $request->bgimg;
        }
        $kiosksetting = $this->queuesettings->getKioskSettings();
        $kiosksetting->bgimg = $name;
        $kiosksetting->save();
        flash()->success('Kiosk Background Image updated');
        return redirect()->route('queuesettings.index');
    }
//----------------------------




//-----------------------

}
