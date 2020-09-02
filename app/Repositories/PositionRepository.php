<?php

namespace App\Repositories;

use App\Position;
use App\Repositories\Interfaces\PositionRepositoryInterface;
use Illuminate\Support\Facades\Log;

/**
 * Class PositoinRepository.
 */
class PositionRepository implements PositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function savePosition($request)
    {
        Log::info("reach");
        try{
        	$position=Position::create($request->all());
        	return response()->json(['status'=>'OK',
		'message'=>'Success Employee Registration'
		],200);
        }catch(QueryException $e){
			return response()->json([
				'message'=>$e->getMessage()
		    ]);
	    }
    }
}
