<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedbigInteger('thread_id');
			$table->text('body');
			$table->integer('status');
			$table->ipAddress('ipaddress')->nullable();
			$table->char('ua', 100)->nullable();
			$table->timestamps();

			$table->foreign('thread_id')->references('id')->on('threads');
			$table->index('thread_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
