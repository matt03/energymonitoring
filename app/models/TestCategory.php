<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class TestCategory extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'testCategories';
    protected  $guarded = array('$id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    public function labTest()
    {
        return $this->hasMany('labTests', 'testCategory_id', 'id');
    }
}
