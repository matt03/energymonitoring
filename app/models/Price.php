<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;

class Price extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mapping_price';
    protected  $guarded = array('$id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function labTests()
    {
        return $this->belongsTo('LabTest', 'procedure_id', 'id');
    }

    public function hospital()
    {
        return $this->belongsTo('Hospital', 'hospital_id', 'id');
    }

}
