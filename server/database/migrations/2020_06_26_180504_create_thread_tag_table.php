<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * スレッド(thread)にどのタグ(tag)が紐づいているかを繋ぐ中間テーブル
     */
    public function up()
    {
        Schema::create('thread_tag_table', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedbigInteger('thread_id');
            $table->unsignedInteger('tag_id');
            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread_tag_table');
    }
}
