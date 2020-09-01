<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */
class Employee extends Model
{
	use SoftDeletes;

	//insert to employees table using model
    protected $fillable=['employee_name','email','dob','password','gender'];
    
    //join with employee table
    public function department(){
    	return $this->belongsToMany('App\Department','emp_dep_positons','employee_id','department_id');
    }

    //join with employee table
    public function position(){
    	return $this->belongsToMany('App\Position','emp_dep_positons','employee_id','position_id');
    }

    
}
