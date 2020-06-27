<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeOffType extends Model
{
	/**
	 * The attributes that are prevent assignable.
	 *
	 * @var array
	 */
	protected $table = 'time_off_type';
	protected $guarded = [];

	public $timestamps = false;
}
