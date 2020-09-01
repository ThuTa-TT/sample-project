<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\Artisan;
   /**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource with paginate.
     * @author Thu Ta
     * 27/08/2020
     * @return \Illuminate\Http\Response
     * @return array[id,dapartment_name,deleted_at,created_at,updated_at]
     */
    public function index()
    {
        //$limit=(int)env('limit');//number of paginate
        $perPage=Config::get('constant.per_page');
        $department = Department::withTrashed()->paginate($perPage);
        return $department;
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
    public function store(DepartmentRequest $request)
    {
        try
        {
            $department=Department::create($request->all());
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
     * @param  int  $id(departments table)
     * @return \Illuminate\Http\Response
     * @return array[id,dapartment_name,deleted_at,created_at,updated_at]
     */
    public function show($id)
    {
        try
        {
            $department = Department::withTrashed()->find($id);
            return response()->json(['status'=>'OK','message'=>$department],200);
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }  
    }

    /**
     * Show the form for editing the specified resource.
     * @author Thu Ta
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @author Thu Ta
     * 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id(departments table)
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        try
        {
            $department=Department::find($id);
            if($department)
            {
                $department->department_name=request()->department_name;
                $department->update();
                return response()->json(['status'=>'OK','message'=>"Update Successful"],200);
            }else{
                return response()->json(['status'=>'NG','message'=>"Update Unsuccessful"],200);
            }  
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }  
    }

    /**
     * Update deleted_at with current time.
     * @author Thu Ta
     * 27/08/2020
     * @param  int  $id(departments table)
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $department=Department::find($id);
            if($department){
                $department->delete();
                return response()->json(['status'=>'OK','message'=>"Delete Successful"],200);
            }else{
                return response()->json(['status'=>'NG','message'=>"Delete Unsuccessful"],200);
            }   
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }  
    }

     /**
     * Remove the specified resource from storage.
     * @author Thu Ta
     * 26/08/2020
     * @param  int  $id(departments table)
     * @return \Illuminate\Http\Response
     */
    public function forcedelete($id)
    {
        try
        {
            $department=Department::withTrashed()->where('id',$id);
            if($department){
                $department->forcedelete();
                return response()->json(['status'=>'OK','message'=>"Delete Successful"],200);
            }else{
                return response()->json(['status'=>'NG','message'=>"Delete Unsuccessful"],200);
            } 
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }      
    }

    /**
     * Search the specified resource from storage.
     * @author Thu Ta
     * 27/08/2020
     * @param  int  $id(departments table)
     * @return \Illuminate\Http\Response
     * @return array[id,dapartment_name,deleted_at,created_at,updated_at]
     */
     public function search(Request $request)
    {
        try
        {
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
            $perPage=Config::get('constant.per_page');
            //$limit=(int)env('limit');
            //$employee=Employee::with('department','position')->where('id',$request->id)->orWhere('employee_name','LIKE','%'.$request->employee_name.'%')->withTrashed()->get();
            $search_arry=[];
            if($request->id)
            {
                //die($request->id);
                $search_id=['id',$request->id];
                array_push($search_arry,$search_id);

            }
            if ($request->department_name) 
            {
                $seaarch_name=['department_name','LIKE',$request->employee_name.'%'];
                array_push($search_arry, $seaarch_name);
            }

            $employee=Department::withTrashed()->where($search_arry)->paginate($perPage);
            return $employee;
        }catch(QueryException $e){
                return response()->json([
                    'message'=>$e->getMessage()
                ]);
            }  
    }

}
