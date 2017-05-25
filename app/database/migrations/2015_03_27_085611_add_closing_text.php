<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClosingText extends Migration {

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
			SurveyQuestions::create(array('question'=>'End of Survey','is_question'=>SurveyQuestions::$END,'order'=>'-4'));

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
