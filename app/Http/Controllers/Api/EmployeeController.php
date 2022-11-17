<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportEmployee;

class EmployeeController extends Controller
{
    // Bulk Import employee data
    public function import(){
        Excel::import(new ImportEmployee, public_path('Employee_Details.xlsx'));
        return response()->json(['Employees Imported.']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::latest()->get();
        return response()->json([EmployeeResource::collection($data), 'Employees fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|unique:employees|max:255',
            'salary' => 'required',
            'doj' => 'required',
            'img' => 'required',
            'gender' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'salary' => $request->salary,
            'doj' => $request->doj,
            'img' => $request->img,
            'gender' => $request->gender,
            'phone' => $request->phone
         ]);
        
        return response()->json(['Employee created successfully.', new EmployeeResource($employee)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if (is_null($employee)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new EmployeeResource($employee)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|unique:employees,email,'.$employee->id,
            'salary' => 'required',
            'doj' => 'required',
            'img' => 'required',
            'gender' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->salary = $request->salary;
        $employee->doj = $request->doj;
        $employee->img = $request->img;
        $employee->gender = $request->gender;
        $employee->phone = $request->phone;
        $employee->save();
        
        return response()->json(['Employee updated successfully.', new EmployeeResource($employee)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json('Employee deleted successfully');
    }
}
