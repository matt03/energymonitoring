<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Sample extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'samples';
    protected  $guarded = array('$id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    public function patient()
    {
        return $this->belongsTo('Patient', 'patient_id', 'id');
    }
public function fixative()
    {
        return $this->belongsTo('Fixative', 'fixative_id', 'id');
    }

    public function procedure()
    {
        return$this->belongsTo('LabTest', 'procedure_id', 'id');
    }

    public function sampleTest()
    {
        return $this->belongsTo('SampleTests', 'sample_test_Id', 'name');
    }

    public function payment()
    {
        return $this->belongsTo('Payment', 'payment_details', 'id');
    }
    public function hospital()
    {
        return $this->belongsTo('Hospital', 'hospital_name', 'id');
    }
}
