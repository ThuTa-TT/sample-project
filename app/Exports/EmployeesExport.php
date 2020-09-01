<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;




/**
	 * Description of this class.
	 * @author Thu Ta
	 * 28/08/2020
	 */
class EmployeesExport implements FromCollection,WithHeadings,WithTitle,ShouldAutoSize,WithEvents,WithMapping
{
	/**
	* Export Excel file of Employee.
	* @author Thu Ta
	* 28/08/2020 
	* @return \Illuminate\Support\Collection\array[employee_name,email,dob,gender]
	*/

	protected $data;

	function __construct($data) {
		$this->data = $data;
	}

	public function collection()
	{
		
		
			// return $employee= Employee::with('department','position')->withTrashed()->where($this->data)->get();   
			//dd($employee); 
			//dd($this->data);
			return $employee=DB::table('employees')
                                    ->join('emp_dep_positons','emp_dep_positons.employee_id','=','employees.id')
                                    ->join('departments','emp_dep_positons.department_id','=','departments.id')
                                    ->join('positions','emp_dep_positons.position_id','=','positions.id')
                                    ->where($this->data)                                  
                                    ->select('employees.*','departments.department_name','positions.position_name')
                                    ->get();
            //dd($employee); 	
		
	}

	/**
	* Heading row of excel.
	* @author Thu Ta
	* 28/08/2020 
	* 
	*/

	public function headings(): array
	{
		return [
			'Employee Name',
			'Email',
			'Date Of Birth ',
			'Gender',
			'Department Name',
			'Position Name'
		];
	}

	/**
	* Title of excel.
	* @author Thu Ta
	* 28/08/2020 
	* 
	*/

	public function title(): string
	{
		return 'Employees';
	}

	/**
	* Display sheet of excel.
	* @author Thu Ta
	* 28/08/2020 
	* 
	*/

	public function registerEvents(): array
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		return [
			AfterSheet::class    => function(AfterSheet $event) {

				$cellRange='A1:F1';
				$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
				$event->sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				->getStartColor()->setARGB('98AFC7');
			},
		];
	}


	public function map($data): array
	{
	    return [
	        $data->employee_name,
	        $data->email,
	        $data->dob,
	        $data->gender,
	        $data->department_name,
	        $data->position_name,
	        
	    ];
	}
}
