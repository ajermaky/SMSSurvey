<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessagesToSurveyQuestionsTable extends Migration {

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
			$preReminderQuestion = 'IPA here! In about %d minutes we will start sending you the first question of the Market Survey. Thank you for your participation.';
			SurveyQuestions::create(array('question'=>$preReminderQuestion,'is_question'=>SurveyQuestions::$PREREMINDER,'order'=>'-1'));
			SurveyQuestions::create(array('question'=>'Invalid Response','is_question'=>SurveyQuestions::$INVALID,'order'=>'-2'));
			SurveyQuestions::create(array('question'=>'You have responded to a closed survey','is_question'=>SurveyQuestions::$CLOSED,'order'=>'-3'));
			//SurveyQuestions::create(array('question'=>'Invalid Response','is_question'=>SurveyQuestions::$INVALID));


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
			$questions = SurveyQuestions::where('is_question','!=','0')->get();
			foreach($questions as $question){
				$question->delete();
			}
		});
	}

}
