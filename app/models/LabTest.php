<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class LabTest extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'labTests';
    protected  $guarded = array('$id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    public function testCategory()
    {
        return $this->belongsTo('TestCategory', 'testCategory_id', 'id');
    }

    public function treatment(){

        return $this->hasMany('Treatment', 'labTest_id', 'id');
    }

    public function  parasitology(){

        return $this->hasMany('Parasitology', 'labTest_id', 'id');
    }
    public function  serology(){

        return $this->hasMany('Serology', 'labTest_id', 'id');
    }
    public function  haematology(){

        return $this->hasMany('Haematology', 'labTest_id', 'id');
    }
}
