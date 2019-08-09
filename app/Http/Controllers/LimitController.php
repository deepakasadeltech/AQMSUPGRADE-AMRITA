<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LimitRepository;
use App\Models\Limit;
use Carbon\Carbon;

class LimitController extends Controller
{
    protected $limits;

    public function __construct(LimitRepository $limits)
    {
        $this->limits = $limits;
    }

    public function index(Request $request)
    {
        $this->authorize('access', limit::class);
        return view('user.superadmin.index', [
            'datalimits' => $this->limits->getLimitData(),
        ]);
		
    }
//---------------------

public function limitDataUpdate(Request $request)
    {  //$this->authorize('access', DisplaySetting::class);
         $this->validate($request, [
            'doctor' => 'bail|required',
            'user' => 'bail|required',
            'cmo' => 'required',
            'displayctrl' => 'required',
            'helpdesk' => 'required',
            'department' => 'required',
            'pdepartment' => 'required',
            'room' => 'required',
            'ads' => 'required',
            'tokenperday' => 'required',
            ]);
            $datalimit = $this->limits->getLimitData();
        $datalimit->doctor = $request->doctor;
        $datalimit->user = $request->user;
        $datalimit->cmo = $request->cmo;
        $datalimit->displayctrl = $request->displayctrl;
        $datalimit->helpdesk = $request->helpdesk;
        $datalimit->department = $request->department;
        $datalimit->pdepartment = $request->pdepartment;
        $datalimit->room = $request->room;
        $datalimit->ads = $request->ads;
        $datalimit->tokenperday = $request->tokenperday;
       
        $datalimit->save();
         flash()->success('Limit Data updated');
        return redirect()->route('limits.index');
    }
//-------------------------

//----------------------------

//-----------------------

}
