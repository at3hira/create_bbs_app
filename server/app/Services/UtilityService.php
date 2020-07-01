<?php

namespace App\Services;

class UtilityService
{
    /** 
     * デバイス判定
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
     * @param Object $image
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
}