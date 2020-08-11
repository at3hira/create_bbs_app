<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model
{
	use SoftDeletes; // 論理削除の利用を宣言
	protected $dates = ['deleted_at']; // 削除日時を入れるカラム

	/*
	 * 下記カラムはユーザーからの入力値を反映させない
	 */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	/*
	 * 各テーブルのリレーション設定
	 */
	public function category ()
	{
		return $this->belongsTo('App\Category', 'category_id');
	}

	public function comment()
	{
		return $this->hasMany('App\Comment');
	}

	public function tags()
	{
		return $this->belongsToMany('App\Tag', 'thread_tag_table');
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
