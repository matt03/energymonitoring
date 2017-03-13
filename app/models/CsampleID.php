<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class CsampleID extends Eloquent  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'c_sampleid';
    protected  $guarded = array('$id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function sample()
    {
        return $this->belongsTo('samples', 'sample_test_Id', 'id');
    }
    public function sampleTest()
    {
        return $this->belongsTo('sampleTests', 'name', 'id');
    }
}
