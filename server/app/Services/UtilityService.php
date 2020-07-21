<?php

namespace App\Services;

use App\Thread;
use App\Tag;

class UtilityService
{
    /** 
     * ユーザーエージェントを使ってPCとその他のデバイス判定
     * @param string $ua ユーザーエージェント
     * @return boolean PC:true iPhone|iPad|Android|iPod:false
     **/
    public function judge_device($ua)
    {
        if ((strpos($ua, 'iPhone') !== false)
            || (strpos($ua, 'iPod') !== false)
            || (strpos($ua, 'iPad') !== false)
            || (strpos($ua, 'Android') !== false)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * サムネイル保存用function
     * 新規スレッドidを含むファイルパスを生成
     * image save : storage/app/public/thread_img
     * image read : public/storage/thread_img
     * 
     * @param int $thr_id
     * @param object $image
     * @return string
    **/
    public function save_thumbnail($thr_id, $image)
    {
        $img_path = storage_path('app/public/thread_img/');
		$img_file = 'thread_'. $thr_id. '.jpg';

        // Intervention読込
		\Image::make($image)
			->resize(1080, 700)->save($img_path. $img_file);
		
        unset($image);
 		return str_replace('/var/www/html/storage/app/public/', '', $img_path. $img_file);
    }

    /**
     * タグをtagsテーブルと中間テーブルに挿入
     * 
     * 中間テーブル：threadテーブルとtagsテーブルを繋ぐテーブル
     * 
     * @param string $request_tags : 登録されるタグ
     * @param object $data : 新規作成されたスレッドのレコード
     */
    public function add_tags_data($request_tags, $data) 
    {

        // カンマ区切りの単語を取得。$tag_listに配列で代入される
        $replace_tags = str_replace('、', ',', $request_tags);
        $tag_list = explode(',', $replace_tags);

		$tags = [];
		foreach($tag_list as $tag) {
			$tag = preg_replace( '/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $tag); //マルチバイトでの空白除去
            /* 
            *  firstOrCreateメソッド
            *  DBにデータが存在する場合は取得、存在しない場合はDBにデータを登録した上でインスタンスを取得する
            */
            $record = Tag::firstOrCreate(['name' => $tag]); // tagsテーブルのnameカラムに該当のない$tagは新規登録
			array_push($tags, $record);
		}

		$tags_id = [];
		foreach($tags as $tag) {
			array_push($tags_id, $tag['id']);  // $tag['id'] : tagsテーブルのid
		}
        $thread = Thread::find($data->id); //$data->id : 作成したスレッドのid

        // attachメソッドを使って中間テーブル(thread_tagテーブル)にデータ挿入
		$thread->tags()->attach($tags_id); 
    }

    /**
     * スレッドに紐づくタグの取得
     * @param object $thread
     * @return object $thread
     */
    public function get_tags($thread)
    {
        // スレッドに紐づいているタグを取得
        $thread->tags = $thread->tags()->orderby('tag_id')->get();
        return $thread;
    }

    /**
     * タグを全件取得し返す(statusカラムが1のデータ)
     * @return object $tags
     */
    public function all_tag_list()
    {
        $tags = Tag::where('status', 1)->orderBy('id')->get();
        return $tags;
    }

}