<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sent_questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('surveys_id')->unsigned();
			$table->integer('questions_id')->unsigned();
			$table->integer('phone_numbers_id')->unsigned();
			$table->string('answer');
			$table->integer('time_sent')->default(0);
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
		Schema::drop('sent_questions');
	}

}
