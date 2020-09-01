<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
     * Description of this class.
     * @author Thu Ta
     * 26/08/2020
     */
class Position extends Model
{
	use SoftDeletes;

	//insert to positions table using model
    protected $fillable=['position_name','position_rank' ];

}
