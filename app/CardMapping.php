<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardMapping extends Model
{
	public $table = "card_mapping";

	protected $guarded = [];

	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}