<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [
		'category_name', 
		'status',
	];

	/*
	 * カテゴリに属するスレッド取得
	 */
	public function threads ()
	{
		return $this->hasMany('App\Thread');
	}
}
