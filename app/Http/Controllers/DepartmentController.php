<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DepartmentRepository;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Limit;


class DepartmentController extends Controller
{
    protected $departments;

    public function __construct(DepartmentRepository $departments)
    {
        $this->departments = $departments;
    }

    public function index()
    {
        $this->authorize('access', Department::class);
		$departments = Department::leftJoin('parent_departments', function($join){
			$join->on('departments.pid', '=', 'parent_departments.id');
		})
		->select('parent_departments.name AS pname', 'departments.*')
		->get();
        return view('user.departments.index', [
            'departments' =>$departments,
        ]);
    }

    public function create()
    {
        $this->authorize('access', Department::class);
		$pdepartment = ParentDepartment::all();
		$uhids = ["1"=>"Yes", "2"=>"No"];
		$data['pdepartment'] = $pdepartment;
		$data['uhids'] = $uhids;
        return view('user.departments.create')->with($data);
    }

    public function store(Request $request)
    {
        $this->authorize('access', Department::class);

        $this->validate($request, [
			'pid' => 'required',
            'name' => 'required',
            'olangname' => 'required',
            'regcode' => 'required',
            'start' =>'required|numeric',
			'is_uhid_required' => 'required',
        ]);
        //echo "<pre>"; print_r($request->all());die;
        
        $limitdata = $this->departments->getLimitData();
        $No_Of_Department = $this->departments->No_Of_Department();

        if($No_Of_Department >= $limitdata->department){
            flash()->warning('You have exceeded the allowed limit: Department');
            return redirect()->route('departments.index');  
         }

        Department::create($request->all());

        flash()->success('Department created');
        return redirect()->route('departments.index');
    }

    public function edit(Request $request, Department $department)
    {
        $this->authorize('access', Department::class);
		$uhids = ["1"=>"Yes", "2"=>"No"];
		return view('user.departments.edit', [
            'department' => $department,
			'pdepartment' => ParentDepartment::all(),
			'uhids' => $uhids
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('access', Department::class);

        $this->validate($request, [
			'pid' => 'required',
            'name' => 'required',
            'olangname' => 'required',
            'regcode' => 'required',
            'start' =>'required|numeric',
			'is_uhid_required' => 'required',
        ]);

        $department->name = $request->name;
        $department->olangname = $request->olangname;
        $department->regcode = $request->regcode;
		$department->pid = $request->pid;
        $department->letter = $request->letter;
        $department->start = $request->start;
		$department->is_uhid_required = $request->is_uhid_required;
        $department->save();

        flash()->success('Department updated');
        return redirect()->route('departments.index');
    }

    public function destroy(Request $request, Department $department)
    {
        $this->authorize('access', Department::class);

        $department->delete();

        flash()->success('Department deleted');
        return redirect()->route('departments.index');
    }
}
