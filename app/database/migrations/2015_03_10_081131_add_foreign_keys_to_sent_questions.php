<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToSentQuestions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sent_questions', function(Blueprint $table)
		{
			//
			$table->foreign('phone_numbers_id')->references('id')->on('phone_numbers')->onDelete('cascade');
			$table->foreign('surveys_id')->references('id')->on('surveys')->onDelete('cascade');
			$table->foreign('questions_id')->references('id')->on('questions')->onDelete('cascade');


	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sent_questions', function(Blueprint $table)
		{
			//
			$table->dropForeign('sent_questions_phone_numbers_id_foreign');
			$table->dropForeign('sent_questions_surveys_id_foreign');
			$table->dropForeign('sent_questions_questions_id_foreign');


		});
	}

}
