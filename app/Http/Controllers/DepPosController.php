<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dep_has_position;
class DepPosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Thu Ta
     * 27/08/2020
     * @return \Illuminate\Http\Response
     * @return array[id,department_id,position_id,deleted_at,updated_at,created_at]
     */
    public function index()
    {
        $limit=(int)env('limit');//number of paginate
         $dep_pos = dep_has_position::withTrashed()->paginate($limit);
         return $dep_pos; 
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

    //insert data into dep_has_positions table
    public function store(Request $request)
    {
        try{
            $dep_pos=dep_has_position::create($request->all());
            return response()->json(['status'=>'OK','message'=>"Save Successful"],200); 
        }catch(QueryException $e)
                {
                    return response()->json([
                        'message'=>$e->getMessage()
                    ]);
                }  
    }

   
    public function show($id)
    {
        try{
                $dep_pos = dep_has_position::withTrashed()->find($id);
                return $dep_pos;    
        }catch(QueryException $e)
                {
                    return response()->json([
                        'message'=>$e->getMessage()
                    ]);
                }    }

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
     * @author Thu Ta
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id(dep_has_positions table)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dep_pos=dep_has_position::find($id);
        if($dep_pos)
        {
            $dep_pos->department_id=request()->department_id;
            $dep_pos->position_id=request()->position_id;
            $dep_pos->update();
            return response()->json(['status'=>'OK','message'=>"Update Successful"],200);
        }
         return response()->json(['status'=>'NG','message'=>"Update Unsuccessful"],200);
    }

    /**
     * Update the specified resource in storage.
     * @author Thu Ta
     * 26/08/2020
     * @param  int  $id(dep_has_positions table)
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dep_pos=dep_has_position::find($id);
        if($dep_pos)
        {
            $dep_pos->delete();
            return response()->json(['status'=>'OK','message'=>"Delete Successful"],200);
        }
            return response()->json(['status'=>'OK','message'=>"Not Found"],200);
            
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
     * @param  int  $id(dep_has_positions table)
     * @return \Illuminate\Http\Response
     */
     public function forcedelete($id)
    {
        $dep_pos=dep_has_position::withTrashed()->where('id',$id);
        if($dep_pos)
        {
            $dep_pos->forcedelete();
            return response()->json(['status'=>'OK','message'=>"Delete Successful"],200);
        }
            return response()->json(['status'=>'OK','message'=>"Not Found"],200);
            
        }catch(QueryException $e)
                {
                    return response()->json([
                        'message'=>$e->getMessage()
                    ]);
                }
           
    }
}
