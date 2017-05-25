<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIsQuestionSurveyQuestions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('survey_questions', function(Blueprint $table)
		{
			//
			$table->dropColumn('is_question');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('survey_questions', function(Blueprint $table)
		{
			//
			$table->integer('is_question')->after('max');
		});
	}

}
