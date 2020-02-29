<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categorys'; // テーブル名指定 model作成時間違ったため
	
	protected $fillable = [
		'category_name', 
		'status',
	];

	/*
	 * カテゴリに属するスレッド取得
	 */
	public function threads ()
	{
		return $this->hasManyThrough('App\Comment', 'App\Thread');
	}
}
