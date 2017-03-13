<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Carbon\Carbon;

class Serology extends Eloquent  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'serology';
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
    public function vitalSign(){

        return $this->belongsTo('LabTest', 'labTest_id', 'id');
    }

    public function getAge()
    {
        return Carbon::parse('dob')->diff(Carbon::now())->format('%y years, %m months and %d days');
    }


}
