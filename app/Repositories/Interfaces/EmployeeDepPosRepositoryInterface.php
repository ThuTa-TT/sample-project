<?php

namespace App\Repositories\Interfaces;

interface EmployeeDepPosRepositoryInterface
{
	public function saveEmployeeDep($employeeId, $pos, $dep);
	public function updateEmpDepPos($request,$pos,$dep);
}