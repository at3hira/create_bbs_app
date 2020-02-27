<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('category_id');
			$table->string('title', 50);
			$table->string('body');
			$table->string('img_url', 100);
			$table->integer('status');
			$table->timestamps();

			$table->foreign('category_id')->references('id')->on('categorys');
			$table->index('category_id');
		});
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
