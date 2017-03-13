<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class SampleTests extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sampleTests';
    protected  $guarded = array('$id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    public function labTests()
    {
        return $this->belongsTo('LabTest', 'labTest_id', 'id');
    }

    public function diagnosis()
    {
        return $this->belongsTo('Diagnosis', 'definite_diagnosis_id', 'id');
    }
    public function sample()
    {
        return $this->hasMany('Sample', 'name', 'sample_test_Id');
    }

    public function doctor()
    {
        return $this->belongsTo('User', 'doctor_id', 'id');
    }
    public function labTechnician()
    {
        return $this->belongsTo('User', 'lab_technician_id', 'id');
    }
}
