<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;



/**
     * Description of this class.
     * @author Thu Ta
     * 28/08/2020
     */
class EmployeesExport implements FromCollection,WithHeadings,WithTitle,ShouldAutoSize,WithEvents
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
        
        
         	return $employee= Employee::withTrashed()->where($this->data)->get(array('employee_name','email','dob','gender'));   
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
            'Dob ',
            'Gender'
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

                $cellRange='A1:D1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('98AFC7');
            },
        ];
    }
}
