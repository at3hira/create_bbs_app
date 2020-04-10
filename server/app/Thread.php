<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	/*
	 * 下記カラムはユーザーからの入力値を反映させない
	 */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	/*
	 * スレッドに該当するカテゴリID取得
	 */
	public function category ()
	{
		return $this->belongsTo('App\Category', 'category_id');
	}

	/**
	 * スレッドのコメントを取得
	 */
	public function comment()
	{
		return $this->hasMany('App\Comment');
	}

	/**
	 * スレッドの一覧を降順で取得
	 * statusカラムが1のみ
	 */
	public function scopeThreadlist($query)
	{
		$query->where('status', 1)->orderBy('created_at', 'desc');
	}
}
