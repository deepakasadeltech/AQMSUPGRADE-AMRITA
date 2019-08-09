<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Repositories\AdRepository;
use App\Models\Counter;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Limit;
use App\Models\Ad;

class AdController extends Controller
{
    protected $ads;

    public function __construct(AdRepository $ads)
    {
        $this->ads = $ads;
    }

    public function index()
    {
        $this->authorize('access', Ad::class);

        return view('user.ads.index', [
            'ads' =>$this->ads->getAll(),
            'pdepartments' => $this->ads->getPDepartments(),
            'departments' => $this->ads->getDepartments(),
            'getcounterdetails' => $this->ads->getcounterMapDetails(),
        ]);

    }

    public function create()
    {
        $this->authorize('access', Ad::class);
        
        return view('user.ads.create',[
            'pdepartments' => $this->ads->getPDepartments(),
            'departments' => $this->ads->getDepartments(),

        ]);
    }


    public function Adimgupdate(Request $request)
    {
        $this->authorize('access', Ad::class);

        $this->validate($request, [
            'adimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1500,height=1300',
        ]);
        
        
        //-------pic-----------   
        if ($request->hasFile('adimg')) {
            $image = $request->file('adimg');
            $name = time().'.'.$image->getClientOriginalExtension(); 
            $destinationPath = public_path('/adsimg');
            $image->move($destinationPath, $name);
        }else{
            $name = $request->adimg;
        }
        //-------------------
        $id = $request->id;
        $ad = $this->ads->getAdimg($id);
        $ad->adimg = $name;
        $ad->save();

    flash()->success('Ads Image updated');
    return redirect()->route('ads.index');

    }

    public function store(Request $request)
    {
        $this->authorize('access', Ad::class);

        $validt = $this->validate($request, [
            'name' => 'bail|required|unique:ads,name',
            'adimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1500,height=1300',
        ]);

        $limitdata = $this->ads->getLimitData();
        $No_Of_Ad = $this->ads->No_Of_Ads();

        if($No_Of_Ad >= $limitdata->ads){
            flash()->warning('You have exceeded the allowed limit: Ads');
            return redirect()->route('ads.index');  
         }

         //-------pic-----------   
        if ($request->hasFile('adimg')) {
            $image = $request->file('adimg');
            $name = time().'.'.$image->getClientOriginalExtension(); 
            $destinationPath = public_path('/adsimg');
            $image->move($destinationPath, $name);
        }else{
            $name = $request->adimg;
        }
        //-------------------
        $data = $request->all();
       // echo "<pre>"; print_r($data);die;
       
        $data['adimg'] = $name;
        

        Ad::create($data);

        flash()->success('Ads created');
        return redirect()->route('ads.index');
    }

    public function edit(Request $request, Ad $ad)
    {
        $this->authorize('access', Ad::class);

        return view('user.ads.edit', [
            'ad' => $ad,
            'pdepartments' => $this->ads->getPDepartments(),
            'departments' => $this->ads->getDepartments(),
        ]);
    }

    public function update(Request $request, Ad $ad)
    {
        $this->authorize('access', Ad::class);

        $this->validate($request, [
            'name' => 'required',
            'adimg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1500,height=1300',
        ]);

        //-------pic-----------   
        if ($request->hasFile('adimg')) {
            $image = $request->file('adimg');
            $name = time().'.'.$image->getClientOriginalExtension(); 
            $destinationPath = public_path('/adsimg');
            $image->move($destinationPath, $name);
        }else{
            $name = $request->adimg;
        }
        //-------------------



        $ad->name = $request->name;
        $ad->adimg = $name;
        
        $ad->save();

        flash()->success('Ads updated');
        return redirect()->route('ads.index');
    }

    public function destroy(Request $request, Ad $ad)
    {
        $this->authorize('access', Ad::class);

        $ad->delete();

        $image_path = public_path('/adsimg'.'/'.$ad->adimg); 
    if(File::exists($image_path)) {
        File::delete($image_path);
    }

        flash()->success('Ad deleted');
        return redirect()->route('ads.index');
    }

    


}
