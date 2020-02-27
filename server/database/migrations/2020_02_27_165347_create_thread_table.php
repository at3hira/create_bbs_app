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
        Schema::create('thread', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('category_id');
			$table->string('title', 50);
			$table->string('body');
			$table->integer('status');
			$table->string('url', 100);
			$table->timestamps();

			$table->foreign('category_id')->references('id')->on('category');
		});
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread');
    }
}
