<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('survey_questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('question');
			$table->integer('order')->unique();
			$table->integer('elements');
			$table->integer('min');
			$table->integer('max');
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
		Schema::drop('survey_questions');
	}

}
