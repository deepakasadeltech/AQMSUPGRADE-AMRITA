<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Models\User;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Counter;
use App\Models\Limit;
use App\Models\Ad;


class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index(Request $request)
    {  
        $this->authorize('access', User::class);

        return view('user.users.index', [
            'users' => $this->users->getAll(),
            'userdoctordetails' => $this->users->getUserDoctorName(),
            'getalluserdetails' => $this->users->getAllUserName(),
            'getadmindetails' => $this->users->getAdminDetails(),
            'gethepdeskdetails' => $this->users->getHelpdeskDetails(),
            'getcmodetails' => $this->users->getCmoDetails(),
            'getdisplayctrldetails' => $this->users->getDisplayCtrlDetails(),
            'doctorrooms' => $this->users->getCounter(),

            'pdepartments' => $this->users->getPDepartments(),
            'departments' => $this->users->getDepartments(),
            'ads' => $this->users->getadsAll(),				
        ]);
    }

    public function create(Request $request)
    {  
         $this->authorize('access', User::class);

        return view('user.users.create',[
            'ads' => $this->users->getadsAll(),	
            'pdepartments' => $this->users->getPDepartments(),
            'departments' => $this->users->getDepartments(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', User::class);

        $this->validate($request, [
            'name' => 'bail|required',
            'username' => 'bail|required|min:6|unique:users,username',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|min:6|confirmed',
            'user_status' => 'bail|required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=200,height=230',
            'profile' => 'bail|required',
        ]);
         $limitdata = $this->users->getLimitData();
         $No_Of_Doctor = $this->users->No_Of_Doctor();
		 $No_Of_Staff = $this->users->No_Of_Staff();
		 $No_Of_Helpdesk = $this->users->No_Of_Helpdesk();
		 $No_Of_CMO = $this->users->No_Of_CMO();
         $No_Of_Displayctrl = $this->users->No_Of_Displayctrl();
        
         if($request->role == 'D'){
         if($No_Of_Doctor >= $limitdata->doctor){
            flash()->warning('You have exceeded the allowed limit: Doctor');
            return redirect()->route('users.index');  
         }}
         if($request->role == 'S'){
         if($No_Of_Staff >= $limitdata->user){
            flash()->warning('You have exceeded the allowed limit: User');
            return redirect()->route('users.index');  
         }}
         if($request->role == 'H'){
         if($No_Of_Helpdesk >= $limitdata->helpdesk){
               flash()->warning('You have exceeded the allowed limit: Helpdesk');
               return redirect()->route('users.index');  
         }}
         if($request->role == 'C'){
          if($No_Of_CMO >= $limitdata->cmo){
                  flash()->warning('You have exceeded the allowed limit: CMO');
                  return redirect()->route('users.index');  
            }}
         if($request->role == 'I'){
            if($No_Of_Displayctrl >= $limitdata->displayctrl){
                        flash()->warning('You have exceeded the allowed limit: Display Controller');
                        return redirect()->route('users.index');  
         }}
        $data = $request->all();
       // echo "<pre>"; print_r($data);die;
       if($data['role'] != 'D') {
        $data['pid'] = NULL;
        $data['department_id'] = NULL;
        $data['ads_id'] = NULL;
       }

    //-------pic-----------   
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $name = time().'.'.$image->getClientOriginalExtension(); 
        $destinationPath = public_path('/doctorimg');
        $image->move($destinationPath, $name);
    }else{
        $name = $request->photo;
    }
    $data['photo'] = $name;
    //-------------------
    // echo "<pre>"; print_r($data);die;
        //$data['role'] = 'S';
        $data['password'] = bcrypt($request->password);

            $user = User::create($data);
            flash()->success('User created');
            return redirect()->route('users.index');
        

        
    }

    public function getPassword(Request $request, User $user)
    {
        $this->authorize('access', User::class);

        if($user->id==$request->user()->id) abort(404);

        return view('user.users.password', [
            'cuser' => $user,
            'ads' => $this->users->getadsAll(),	
        ]);
    }

    public function postPassword(Request $request, User $user)
    {
        $this->authorize('access', User::class);

        if($user->id==$request->user()->id) abort(404);

        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'ads_id' => 'required',
        ]);

        $user->password = bcrypt($request->password);
        $user->ads_id = $request->ads_id;
        $user->save();

        flash()->success('User Data Updated');
        return redirect()->route('users.index');
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorize('access', User::class);

        $user->delete();

        $image_path = public_path('/doctorimg'.'/'.$user->photo); 
    if(File::exists($image_path)) {
        File::delete($image_path);
    }

        flash()->success('User deleted');
        return redirect()->route('users.index');
    }

    public function postUpDept(Request $request)
    { 
		$department = Department::where('pid', $request->pid)->get();
        return $department->toJson();
    }

    public function updateStatus($id)
    {
        $users = User::find($id);
        if($users->user_status == 1) {
            $users->user_status = 2;
            $msg = "User Inactive";
        }else{
            $users->user_status = 1;
            $msg = "User Active";
        }

        $users->save();
        flash()->success($msg);
        return redirect()->route('users.index');

    }

}
