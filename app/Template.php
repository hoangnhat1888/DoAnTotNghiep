<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	/**
	 * The attributes that are prevent assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public $timestamps = false;
	
	public function user(){
		return $this->belongsTo('App\User');
	}
	
}
