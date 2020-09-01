<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Position;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\PositionRequest;

/**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */
class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author Thu Ta
     * 27/08/2020
     * @return \Illuminate\Http\Response
     * @return array[position_id,position_rank,deleted_at,created_at,updated_at]
     */
    public function index()
    {
        //$limit=(int)env('limit');//number of paginate
        $perPage=Config::get('constant.per_page');
        $position = Position::withTrashed()->paginate($perPage);
        return $position;    
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
    public function store(PositionRequest $request)
    {
        try{
           $position=Position::create($request->all());
            return response()->json(['status'=>'OK','message'=>"Save Successful"],200); 
        }catch(QueryException $e)
                {
                    return response()->json([
                        'message'=>$e->getMessage()
                    ]);
                }
        
    }

    /**
     * Display the specified resource.
     * @author Thu Ta
     * 27/08/2020
     * @param  int  $id(positions table)
     * @return \Illuminate\Http\Response
     * @return array[position_id,position_rank,deleted_at,created_at,updated_at]
     */
    public function show($id)
    {
        try{
                $position = Position::withTrashed()->find($id);
                return $position;    
        }catch(QueryException $e)
                {
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
     * @author Thu Ta
     * 26/08/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id(positions table)
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, $id)
    {
        $position=Position::find($id);
        if($position){
            $position->position_name=request()->position_name;
            $position->position_rank=request()->position_rank;
            $position->update();
            return response()->json(['status'=>'OK','message'=>"Update Successful"],200);
        }
         return response()->json(['status'=>'NG','message'=>"Update Unsuccessful"],200);

       
    }

    /**
     *Update deleted at with current time.
     * @author Thu ta
     * 26/08/2020
     * @param  int  $id(positions table)
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $position=Position::find($id);
            if($position){
                $position->delete();
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
     * @author Thu ta
     * 26/08/2020
     * @param  int  $id(positions table)
     * @return \Illuminate\Http\Response
     */
    public function forcedelete($id)
    {
        try{
            
                $position=Position::withTrashed()->where('id',$id);
                if($position){
                    $position->forcedelete();
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
