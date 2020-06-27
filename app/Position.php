<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	/**
	 * The attributes that are prevent assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public $timestamps = false;
}
