<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
	/**
	 * The attributes that are prevent assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public $timestamps = false;

	public function User()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
