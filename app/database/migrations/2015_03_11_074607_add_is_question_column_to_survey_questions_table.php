<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsQuestionColumnToSurveyQuestionsTable extends Migration {

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
			$table->tinyInteger('is_question')->after('max')->default(0);
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
			$table->dropColumn('is_question');
		});
	}

}
