<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\employee;
use Barryvdh\Debugbar\DataCollector\ViewCollector;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    public function  index()
    {
        $departments = department::all();
        return view('employee.index', ['employees' => employee::latest()->paginate(10), 'departments' => $departments]);
    }
    public function  delete(Request $request)
    {
        $employee = employee::find($request->id);
        if (file_exists('image/' . $employee->image))
            unlink('image/' . $employee->image);
        $employee->delete();
        return back()->withSuccess('User Deleted');
    }
    public function  fetchOne(Request $request)
    {
        $employee = employee::find($request->id);
        return ['employee' => $employee];
    }
    public function  update(Request $request)
    {
        $employee = employee::find($request->id);
        $employee->name = $request->name;
        $employee->mobile = $request->mobile;
        if ($request->department == "addNew") {

            $department = new department();
            $department->name = $request->newDepartmentName;
            $department->address = $request->newDepartmentAddress;
            $department->save();
            $department = $department->id;
        } else {
            $department = $request->department;
        }
        $employee->department_id = $department;
        if ($request->image) {
            if ($employee->image or $employee->image != "") {
                if (file_exists('image/' . $employee->image)) {
                    unlink('image/' . $employee->image);
                }
            }
            $imageName = time() . "." . $request->image->extension();
            $request->image->move(public_path('image'), $imageName);
            $employee->image = $imageName;
        }
        $employee->save();
        return back()->withSuccess('User Updated');
    }
    public function  create()
    {
        $departments = department::all();
        return view('employee.create', ['departments' => $departments]);
    }
    public function  createStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'department' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1000',
        ]);

        $employee = new employee();
        $employee->name = $request->name;
        $employee->mobile = $request->mobile;
        $employee->department_id = $request->department;
        $imageName = time() . "." . $request->image->extension();
        $request->image->move(public_path('image'), $imageName);
        $employee->image = $imageName;
        $employee->save();
        return back()->withSuccess('User Created');
    }
}
