<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Payment extends Eloquent  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment';
    protected  $guarded = array('$id');

    public function patient()
    {
        return $this->belongsTo('Patient', 'pid', 'id');
    }

    public function hospital()
    {
        return $this->belongsTo('Hospital', 'pid', 'id');
    }
    public function transaction()
    {
        return $this->hasMany('Transaction', 'payment_id', 'id');
    }
} 