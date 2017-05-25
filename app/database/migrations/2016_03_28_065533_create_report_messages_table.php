<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('report_messages', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('surveys_id')->unsigned();
            $table->integer('sent_questions_id')->unsigned()->nullable();
            $table->integer('phone_numbers_id')->unsigned();
            $table->text('message');
            $table->integer('message_id')->unsigned();
            $table->integer('status_code')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('report_messages');
	}

}
