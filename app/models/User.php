<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rsmsa_users';
    protected  $guarded = array('$id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


    public function name()
    {
        if ($this->username) {
            return $this->username;
        } else {
            return $this->firstName . ' ' . $this->lastName;
        }
    }

    public function hasRole()
    {
        return $this->belongsTo('Role', 'role', 'id');
    }
}
