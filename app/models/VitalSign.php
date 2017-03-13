<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Carbon\Carbon;

class VitalSign extends Eloquent  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vitalSigns';
    protected  $guarded = array('$id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function patient(){

        return $this->belongsTo('Patient');
    }

}
