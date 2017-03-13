<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Transaction extends Eloquent  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transaction';
    protected  $guarded = array('$id');

    public function payment()
    {
        return $this->belongsTo('Payment', 'payment_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }

} 