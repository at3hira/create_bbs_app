<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [
		'body',
		'status',
	];

	public function thread() 
	{
		return $this->belongsTo('App\Post');
	}
}
