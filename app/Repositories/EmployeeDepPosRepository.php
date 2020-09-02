<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EmployeeDepPosRepositoryInterface;
// use Illuminate\Support\Facades\Log;
use App\emp_dep_positon;

class EmployeeDepPosRepository implements EmployeeDepPosRepositoryInterface
{
	public function saveEmployeeDep($employeeId, $pos, $dep)
	{
		// Log::info("reach");
        try{
			$emp_dep_pos=new emp_dep_positon();
	        $emp_dep_pos->employee_id=$employeeId;
	        $emp_dep_pos->department_id=$dep;
	        $emp_dep_pos->position_id=$pos;
	        $emp_dep_pos->save(); 
	        return response()->json(['status'=>'OK','message'=>"Save Successful"],200);
		}catch(QueryException $e){
		return response()->json([
			'message'=>$e->getMessage()
		]);
		}
	}

	public function updateEmpDepPos($request,$pos,$dep)
	{
		$emp_dep_pos=emp_dep_positon::where('employee_id',$request->id)->first();
        $emp_dep_pos->department_id=$dep;
        $emp_dep_pos->position_id=$pos;
        $emp_dep_pos->update();
	}

}