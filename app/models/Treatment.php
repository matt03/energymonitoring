<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Treatment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'treatments';
    protected  $guarded = array('$id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    public function labTest()
    {
        return $this->belongsTo('LabTest', 'labTest_id', 'id');
    }
    public function patient()
    {
        return $this->belongsTo('Patient', 'patient_id', 'id');
    }
    public function testCategory()
    {
        return $this->belongsTo('TestCategory', 'labTest_id', 'id');
    }


}
