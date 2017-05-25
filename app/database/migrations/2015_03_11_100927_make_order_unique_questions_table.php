<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeOrderUniqueQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		/*$questions = SurveyQuestions::where('order','=',0)->get();
		$i = 1;
		foreach($questions as $question){
			$question->order = -1*$i++;
			$question->save();
		}

		Schema::table('survey_questions', function(Blueprint $table)
		{
			//

			$table->unique('order');
		});*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	/*	Schema::table('survey_questions', function(Blueprint $table)
		{
			//
			$table->dropUnique('survey_questions_order_unique');
		});
		$questions = SurveyQuestions::where('order','<',0);
		foreach($questions as $question){
			$question->order = 0;
			$question->save();
		}
*/
	}

}
