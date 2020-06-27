<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingTimeOff extends Model
{
	public $table = "booking_time_off";

	/**
	 * The attributes that are prevent assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}