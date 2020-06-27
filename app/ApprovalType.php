<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalType extends Model
{
	/**
	 * The attributes that are prevent assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public $timestamps = false;
}
