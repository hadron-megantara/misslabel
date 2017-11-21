<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Employee;

class EmployeeController extends Controller
{
    public function list(Request $request){
    	$user = array();
        if($request->has('user')){
            $user = $request->user;
        }

        $employee = Employee::get();

        return view("employee.list", array('user' => $user, 'employee' => $employee));
    }

    public function getEmployee(Request $request){
        $employee = Employee::select(['id', 'name', 'phone'])->orderBy('updated_at', 'desc')->get();
     
        return Datatables::of($employee)->make();
    }

    public function storeEmployee(Request $request){
        $employee = new Employee;

        $employee->name = $request->name;
        $employee->phone = $request->phone;

        $employee->save();

        return redirect('/employee/list')->with('success', 'Sukses menambah karyawan');
    }

    public function updateEmployee(Request $request){
        $employee = Employee::find($request->id);
        
        $employee->name = $request->name;
        $employee->phone = $request->phone;

        $employee->save();

        return redirect('/employee/list')->with('success', 'Sukses mengubah karyawan');
    }

    public function destroyEmployee(Request $request){
        $employee = Employee::find($request->id);

        $employee->delete();

        return redirect('/employee/list')->with('success', 'Sukses menghapus karyawan');
    }
}
