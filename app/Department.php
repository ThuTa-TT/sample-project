<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */
class Department extends Model
{
	use SoftDeletes;

	//insert to departments table using model
	protected $fillable=['department_name'];
    

}
