<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */
class emp_dep_positon extends Model
{
	use SoftDeletes;

	//insert to emp_dep_position table using model
    protected $fillable=['employee_id','department_id','position_id'];
   
   
}
