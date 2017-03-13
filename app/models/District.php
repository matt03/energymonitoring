<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class District extends Eloquent  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'districts';
    protected  $guarded = array('$id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function region()
    {
        return $this->belongsTo('Region');
    }

    public function patient()
    {
        return $this->hasMany('Patient', 'district_id', 'id');
    }
}
