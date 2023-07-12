<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    public function  index()
    {
        return view('employee.index', ['employees' => employee::latest()->paginate(2)]);
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
        if ($request->image) {
            if (file_exists('image/' . $employee->image))
            unlink('image/' . $employee->image);
            $imageName = time() . "." . $request->image->extension();
            $request->image->move(public_path('image'), $imageName);
            $employee->image = $imageName;
        }
        $employee->save();
        return back()->withSuccess('User Updated');
    }
    public function  create()
    {
        return view('employee.create');
    }
    public function  createStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1000',
        ]);

        $employee = new employee();
        $employee->name = $request->name;
        $employee->mobile = $request->mobile;
        $imageName = time() . "." . $request->image->extension();
        $request->image->move(public_path('image'), $imageName);
        $employee->image = $imageName;
        $employee->save();
        return back()->withSuccess('User Created');
    }
}
