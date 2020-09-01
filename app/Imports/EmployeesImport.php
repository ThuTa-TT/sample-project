<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;


/**
     * Description of this class.
     * @author Thu Ta
     * 28/08/2020
     */
class EmployeesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'employee_name'=>$row[0],
            'email'=>$row[1],
            'dob'=>$row[2],
            'password'=>$row[3],
            'gender'=>$row[4],
            
        ]);
    }
}
