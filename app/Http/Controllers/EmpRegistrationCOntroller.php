<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmpRegistrationValidationRequest;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Logics\EmployeeRegistrationLogic;
use App\Employee;
use App\emp_dep_positon;


class EmpRegistrationCOntroller extends Controller
{

	public function __construct(EmployeeRepositoryInterface $employeeRepo, EmployeeRegistrationLogic $employeeRepoLogic)
    {       
        $this->employeeRepo = $employeeRepo;
        $this->employeeRepoLogic = $employeeRepoLogic;
    }

	public function save(EmpRegistrationValidationRequest $request)
	{

		$this->employeeRepo->saveEmployee($request);
		$this->employeeRepoLogic->savePrepareDate($request);
		return response()->json(['status'=>'OK',
		'message'=>'Success Employee Registration'
		],200);

	}


	public function update(Request $request)
	{

		$employee=$this->employeeRepo->checkEmployee($request);

		if($employee->isNotEmpty()){
			$this->employeeRepo->updateEmployee($request);
			$this->employeeRepoLogic->updateEmpDepPos($request);
			return response()->json(['status'=>'OK',
				'message'=>'Update Employee Registration'],200);
		}else{
			return response()->json(['status'=>'NG',
				'message'=>'Id Not FOund'],200);
		}
	}
    
}
