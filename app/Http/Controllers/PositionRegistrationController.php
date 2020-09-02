<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PositionRequest;
use App\Repositories\Interfaces\PositionRepositoryInterface;

class PositionRegistrationController extends Controller
{
	public function __construct(PositionRepositoryInterface $posRepo)
    {       
        $this->posRepo = $posRepo;
        
    }
    
    public function save(PositionRequest $request)
	{

		$this->posRepo->savePosition($request);
		
		return response()->json(['status'=>'OK',
		'message'=>'Success Employee Registration'
		],200);

	}
}
