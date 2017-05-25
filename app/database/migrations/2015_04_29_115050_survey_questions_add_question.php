<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SurveyQuestionsAddQuestion extends Migration {

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
			SurveyQuestions::create(array('question'=>'Please Respond','is_question'=>SurveyQuestions::$INVALID,'order'=>'-5'));

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
		});
	}

}
