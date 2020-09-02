<?php

namespace App\Repositories\Logics;

use App\Employee;
use Illuminate\Support\Facades\Config;
use App\Repositories\Interfaces\EmployeeDepPosRepositoryInterface;

class EmployeeRegistrationLogic
{
	public function __construct(EmployeeDepPosRepositoryInterface $employeeRepo)
    {       
        $this->employeeRepo = $employeeRepo;
        
    }   

    public function savePrepareDate($request)
    {        
        $department=Config::get('constant.department');
        $position=Config::get('constant.position');
        // $department=1;
        // $position=1;


		if ($request->position_id) {
            $pos=$request->position_id;
        }else{
            $pos=$position;
        }

        if($request->department_id) {
            $dep=$request->department_id;
        }else{
            $dep=$department;
        }
                
        $employeeId = Employee::max('id');
        $this->employeeRepo->saveEmployeeDep($employeeId, $pos, $dep);
        
    }

    public function updateEmpDepPos($request)
    {

        $department=Config::get('constant.department');
        $position=Config::get('constant.position');

        if ($request->position_id) {
            $pos=$request->position_id;
        }else{
            $pos=$position;
        }

        if($request->department_id) {
            $dep=$request->department_id;
        }else{
            $dep=$department;
        }

         $this->employeeRepo->updateEmpDepPos($request,$pos,$dep);

    }
}