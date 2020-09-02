<?php

namespace App\Repositories;

use App\Employee;
use App\emp_dep_positon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
//use Your Model

/**
* Class EmployeeRepository.
*/
class EmployeeRepository implements EmployeeRepositoryInterface
{
/**
* @return string
* Return the model
*/
public function saveEmployee($request)
{
	try{
		$employee= new Employee();
		$employee->employee_name= $request['employee_name'];
		$employee->email= $request['email'];
		$employee->dob= $request['dob'];
		$employee->password= Hash::make($request['password']);
		$employee->gender= $request['gender'];
		$employee->save();
		return response()->json(['status'=>'OK',
		'message'=>'Success Employee Registration'
		],200);
	}catch(QueryException $e){
		return response()->json([
			'message'=>$e->getMessage()
		]);		
	}
}

public function checkEmployee($request)
{
	$empid=$request->id;
	$employee=DB::table('employees')
				->join('emp_dep_positons','emp_dep_positons.employee_id','=','employees.id')
				->where('employees.id',$empid)
				->get();
	return $employee;
}

public function updateEmployee($request)
{
	// var_dump($request);
	// die();
		$employee=Employee::find($request->id);
		$employee->employee_name=request()->employee_name;
	    $employee->email=request()->email;
	    $employee->dob=request()->dob;
	    $employee->password=request()->password;
	    $employee->gender=request()->gender;
	    $employee->update();

	

}
}