<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CounterRepository;
use App\Models\Counter;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Limit;

class CounterController extends Controller
{
    protected $counters;

    public function __construct(CounterRepository $counters)
    {
        $this->counters = $counters;
    }

    public function index()
    {
        $this->authorize('access', Counter::class);

        return view('user.counters.index', [
            'counters' =>$this->counters->getAll(),
            'pdepartments' => $this->counters->getPDepartments(),
            'departments' => $this->counters->getDepartments(),
            'getcounterdetails' => $this->counters->getcounterMapDetails(),
        ]);

    }

    public function create()
    {
        $this->authorize('access', Counter::class);
        
        return view('user.counters.create',[
            'pdepartments' => $this->counters->getPDepartments(),
            'departments' => $this->counters->getDepartments(),

        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', Counter::class);

        $this->validate($request, [
            'name' => 'bail|required|unique:counters,name',
            'display_sequence' => 'required',
            'pid' => 'required',
            'department_id' => 'required',
        ]);

        $limitdata = $this->counters->getLimitData();
        $No_Of_Counter = $this->counters->No_Of_Counter();

        if($No_Of_Counter >= $limitdata->room){
            flash()->warning('You have exceeded the allowed limit: Room');
            return redirect()->route('counters.index');  
         }

        Counter::create($request->all());

        flash()->success('Counter created');
        return redirect()->route('counters.index');
    }

    public function edit(Request $request, Counter $counter)
    {
        $this->authorize('access', Counter::class);

        return view('user.counters.edit', [
            'counter' => $counter,
            'pdepartments' => $this->counters->getPDepartments(),
            'departments' => $this->counters->getDepartments(),
        ]);
    }

    public function update(Request $request, Counter $counter)
    {
        $this->authorize('access', Counter::class);

        $this->validate($request, [
            'name' => 'required',
            'display_sequence' => 'required',
            'pid' => 'required',
            'department_id' => 'required',
        ]);

        $counter->name = $request->name;
        $counter->display_sequence = $request->display_sequence;
        $counter->pid = $request->pid;
        
        $counter->department_id = $request->department_id;
        $counter->save();

        flash()->success('Counter updated');
        return redirect()->route('counters.index');
    }

    public function destroy(Request $request, Counter $counter)
    {
        $this->authorize('access', Counter::class);

        $counter->delete();

        flash()->success('Counter deleted');
        return redirect()->route('counters.index');
    }

    public function postMpDept(Request $request)
    { 
		$department = Department::where('pid', $request->pid)->get();
        return $department->toJson();
    }


}
