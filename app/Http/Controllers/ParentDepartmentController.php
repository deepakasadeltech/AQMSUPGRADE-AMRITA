<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ParentDepartmentRepository;
use App\Models\ParentDepartment;
use App\Models\Limit;

class ParentDepartmentController extends Controller
{
    protected $pdepartments;

    public function __construct(ParentDepartmentRepository $pdepartments)
    {
        $this->pdepartments = $pdepartments;
    }

    public function index()
    {
        $this->authorize('access', ParentDepartment::class);

        return view('user.parent_departments.index', [
            'parent_departments' =>$this->pdepartments->getAll(),
        ]);
    }

    public function create()
    {
        $this->authorize('access', ParentDepartment::class);

        return view('user.parent_departments.create');
    }

    public function store(Request $request)
    {
        $this->authorize('access', ParentDepartment::class);

        $this->validate($request, [
            'name' => 'required',
            'olangname' => 'required' 
        ]);
        
        $limitdata = $this->pdepartments->getLimitData();
        $No_Of_Pdepartment = $this->pdepartments->No_Of_Pdepartment();
       // print_r('pd'.$No_Of_Pdepartment); print_r('subdept'.$limitdata->supdepartment); die;
        if($No_Of_Pdepartment >= $limitdata->pdepartment){
            flash()->warning('You have exceeded the allowed limit: Parent Department');
            return redirect()->route('parent_departments.index');  
         }


        ParentDepartment::create($request->all());

        flash()->success('Parent Department created');
        return redirect()->route('parent_departments.index');
    }

    public function edit($id)
    {
        $this->authorize('access', ParentDepartment::class);
        return view('user.parent_departments.edit', [
            'department' =>  ParentDepartment::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('access', ParentDepartment::class);

        $this->validate($request, [
            'name' => 'required',
            'olangname' => 'required'             
        ]);
		$parent_departments = ParentDepartment::find($id);
        $parent_departments->name = $request->name;
        $parent_departments->olangname = $request->olangname;
        $parent_departments->save();
		flash()->success('Parent Department updated');
        return redirect()->route('parent_departments.index');
    }

    public function destroy($id)
    {
        $this->authorize('access', ParentDepartment::class);
		$pepartment = ParentDepartment::find($id);
        $pepartment->delete();
        flash()->success('Parent Department deleted');
        return redirect()->route('parent_departments.index');
    }
}
