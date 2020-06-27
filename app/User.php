<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable 
{
	use Notifiable;
	use SoftDeletes;

	/**
	 * The attributes that are prevent assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	// protected $fillable = [
	// 	'username', 'email', 'password',
	// ];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'roles' => 'array'
	];

	/***
	 * @param $role
	 * @return $this
	 */
	public function addRole($role)
	{
		$roles = $this->getRoles();
		$roles[] = $role;

		$roles = array_unique($roles);
		$this->setRoles($roles);

		return $this;
	}

	/**
	 * @param array $roles
	 * @return $this
	 */
	public function setRoles(array $roles)
	{
		$this->setAttribute('roles', $roles);
		return $this;
	}

	/***
	 * @param $role
	 * @return mixed
	 */
	public function hasRole($role)
	{
		return in_array($role, $this->getRoles());
	}

	/***
	 * @param $roles
	 * @return mixed
	 */
	public function hasRoles($roles)
	{
		$currentRoles = $this->getRoles();
		foreach ($roles as $role) {
			if (!in_array($role, $currentRoles)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return array
	 */
	public function getRoles()
	{
		$roles = $this->getAttribute('roles');

		if (is_null($roles)) {
			$roles = [];
		}

		return $roles;
	}

	public function position() {
		return $this->belongsTo('App\Position');
	}

	public function workSchedule()
	{
		return $this->hasMany('App\WorkSchedule');
	}

	public function bookTimeoff()
	{
		return $this->belongsTo('App\BookingTimeOff');
	}

	public function workStatistic()
	{
		return $this->hasMany('App\WorkStatistic');
	}
	public function template()
	{
		return $this->hasMany('App\Template');
	}
	// public function user()
	// {
	// 	return $this->hasMany('App\User');
	// }




	// public function getSchedule(string $day_of_week)
	// {
	// 	return $this->hasMany('App\WorkSchedule')->select('work_time')->where('kind_of_day', $day_of_week);
	// }

}
