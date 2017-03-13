<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Carbon\Carbon;

class Patient extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patients';
    protected  $guarded = array('$id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    public function sample()
    {
        return $this->hasMany('Sample', 'patient_id', 'id');
    }
    public function parasitology()
    {
        return $this->hasMany('Parasitology', 'patient_id', 'id');
    }
    public function serology()
    {
        return $this->hasMany('Serology', 'patient_id', 'id');
    }

    public function haematology()
    {
        return $this->hasMany('Haematology', 'patient_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo('District', 'district_id', 'id');
    }
    public function vitalSign(){

        return $this->hasMany('VitalSign');
    }

    public function treatment(){

        return $this->hasManay('Treatment', 'patient_id', 'id');
    }

    public function getAge()
    {
        return Carbon::parse('dob')->diff(Carbon::now())->format('%y years, %m months and %d days');
    }


}
