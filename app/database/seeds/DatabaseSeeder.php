<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');

		$question1 = "What is the typical price YOU pay (UGX/unit) if you buy Maize, Beans and Tomatoes today? (e.g. 4.5#37#21.5)";
		$question2 = "What is the typical price (UGX/unit) a FARMER would sell Maize, Beans and Tomatoes today?";
		$question3 = "Number of VENDORS selling Maize Beans and Tomatoes at the market point?";
		$question4 = "Total estimated QUANTITY of Maize, Beans and Tomatoes for sale on market today (units)?";
		$question5 = "Rank from 1-5 the average QUALTIY of Maize, Beans and Tomatoes being sold in the market today?";

		SurveyQuestions::create(array('question'=>$question1, 'order'=>1,'min'=>0,'max'=>99999,'elements'=>3));
		SurveyQuestions::create(array('question'=>$question2, 'order'=>2,'min'=>0,'max'=>99999,'elements'=>3));
		SurveyQuestions::create(array('question'=>$question3, 'order'=>3,'min'=>0,'max'=>99999,'elements'=>3));
		SurveyQuestions::create(array('question'=>$question4, 'order'=>4,'min'=>0,'max'=>99999,'elements'=>3));
		SurveyQuestions::create(array('question'=>$question5, 'order'=>5,'min'=>1,'max'=>5,'elements'=>3));
		
	}

}
