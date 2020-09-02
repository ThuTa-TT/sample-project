<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Employee;
use App\emp_dep_positon;
use Maatwebsite\Excel\Facades\Excel; 
use App\Imports\EmployeesImport; 
use App\Exports\EmployeesExport;
use PDF;
use DB;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Artisan;//to clear cache,config



/**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Thu Ta
     * 27/08/2020
     * @return array[id,employee_name,email,dob,password,gender,deleted_at,created_at,updated_at]
     */
    public function index()
    {
        $perPage=Config::get('constant.per_page');
        //$limit=(int)env('limit');//number of paginate
         $employees = Employee::with('department','position')->withTrashed()->paginate($perPage);
         return $employees;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @author Thu Ta
     * 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        try
        {
            $department=Config::get('constant.department');
            $position=Config::get('constant.position');

            $employee=Employee::create($request->all());

            $maxid=Employee::max('id');
            if ($request->position_id)
            {
                $pos=$request->position_id;

            }else{
                $pos=$position;
            }
            if($request->department_id)
            {
                $dep=$request->department_id;

            }else{
                $dep=$department;
            }

            $emp_dep_pos=new emp_dep_positon();
            $emp_dep_pos->employee_id=$maxid;
            $emp_dep_pos->department_id=$dep;
            $emp_dep_pos->position_id=$pos;
            $emp_dep_pos->save(); 

            Mail::raw('Your registration process is complete.',function($message){
                $message->subject('Dear Employee')->from('lonlon.blah@gmail.com')->to('thureinlynn.acc4889@gmail.com');
            });
            return response()->json(['status'=>'OK','message'=>"Save Successful"],200);  
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }  
    }

    /**
     * Display the specified resource.
     * @author Thu Ta
     * 27/08/2020
     * @param  int  $id(employees table)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $employees = Employee::with('department','position')->withTrashed()->find($id);
            return $employees;
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Thu ta
     * 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id(employees table)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
                $department=Config::get('constant.department');
                $position=Config::get('constant.position');

                $employee=Employee::find($id);
                $employee->employee_name=request()->employee_name;
                $employee->email=request()->email;
                $employee->dob=request()->dob;
                $employee->password=request()->password;
                $employee->password=request()->gender;
                $employee->update();

                $emp_dep_pos=emp_dep_positon::where('employee_id',$id)->first();
                
                if($emp_dep_pos)
                {
                    if ($request->position_id)
                    {
                        $pos=$request->position_id;

                    }else{
                        $pos=$department;
                    }
                    if($request->department_id)
                    {
                        $dep=$request->department_id;

                    }else{
                        $dep=$department;
                    }
                
                   
                    $emp_dep_pos->department_id=$dep;
                    $emp_dep_pos->position_id=$pos;
                    $emp_dep_pos->update();
                }
                return response()->json(['status'=>'OK','message'=>"Update Successful"],200);
            }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }
    }

    /**
     * Update deleted_at with current time.
     * @author Thu Ta
     * 26/28/2020
     * @param  int  $id(employees table)
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try{
            if($employee=Employee::find($id))
            {
                $employee->delete();

                $emp_dep_pos=emp_dep_positon::where('employee_id',$id)->first();
                
                if($emp_dep_pos)
                {
                    $emp_dep_pos->delete();
                }
                return response()->json(['status'=>'OK','message'=>"Delete Successful"],200);
            }else{
              return response()->json(['status'=>'NG','message'=>"Delete Unsuccessful"],200);
            }
            
            }catch(QueryException $e)
                {
                    return response()->json([
                        'message'=>$e->getMessage()
                    ]);
                }
    }

     /**
     * Remove the specified resource from storage.
     * @author Thu Ta
     * 26/08/2020
     * @param  int  $id(employees table)
     * @return \Illuminate\Http\Response
     */
    public function forcedelete($id)
    {

         try{

            $employee=Employee::withTrashed()->where('id',$id);
            if($employee)
            {
                 $employee->forcedelete();
            }
            $emp_dep_pos=emp_dep_positon::withTrashed()->where('employee_id',$id)->first();
            if($emp_dep_pos)
            {
                $emp_dep_pos->forcedelete();

            }
                return response()->json(['status'=>'OK','message'=>"Delete Successful"],200);
            }catch(QueryException $e)
                {
                    return response()->json([
                        'message'=>$e->getMessage()
                    ]);
                }
    }

    /**
     * Search the specified resource from storage.
     * @author Thu Ta
     * 27/08/2020
     * @param  int  $id(employees table)
     * @return \Illuminate\Http\Response
     * @return array[id,employee_name,email,dob,password,gender,department_id,position_id]
     */
    public function search(Request $request)
    {
        //die($request);
        try
        {
            // Artisan::call('cache:clear');//clear cache
            // Artisan::call('config:cache');//clear config
            $perPage=Config::get('constant.per_page');
            // $limit=(int)env('limit');

            //$employee=Employee::with('department','position')->where('id',$request->id)->orWhere('employee_name','LIKE','%'.$request->employee_name.'%')->withTrashed()->get();
            $search_arry=[];
            if($request->id)
            {
                //die($request->id);
                $search_id=['id',$request->id];
                array_push($search_arry,$search_id);

            }
            if ($request->employee_name) 
            {
                $seaarch_name=['employee_name','LIKE',$request->employee_name.'%'];
                array_push($search_arry, $seaarch_name);
            }

            $employee=Employee::with('department','position')->withTrashed()
                    ->where($search_arry)->paginate($perPage);
            return response()->json(['status'=>'OK','message'=>$employee],200);
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }  
    }


     /**
     * Import the specified resource from storage.
     * @author Thu Ta
     * 28/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function fileImport(Request $request) 
    { 
        Excel::import(new EmployeesImport, $request->file('file')->store('temp')); 
        return back(); 
    }

    /**
     * Export the specified resource from storage.
     * @author Thu Ta
     * 28/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileExport(Request $request) 
    { 
        //$data=$request->all();
         /*$data=$request->id;
         $name=$request->name;*/
         $data=[];
        if($request->id)
        {
            $data_id=['employees.id',$request->id];
            array_push($data, $data_id);
        }
        if ($request->employee_name) 
        {
            $data_name=['employees.employee_name','LIKE',$request->employee_name.'%'];
            array_push($data, $data_name);
        }
        //$aa=Employee::with('department','position')->where($data);
        return Excel::download(new EmployeesExport($data), 'Emp_list.xlsx');
    }
}
