<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */
class dep_has_position extends Model
{
	use SoftDeletes;

	//insert to dep_has_position table using model 
    protected $fillable=[ 'department_id','position_id'];

    
}
