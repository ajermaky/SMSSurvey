<?php

 	class SurveyQuestions extends Eloquent{

 		public static $PREREMINDER = -1;
 		public static $CLOSED = -3;
 		public static $INVALID = -2;
 		public static $END = -4;
 		public static $UNANSWERED = -5;

 		protected $table = 'survey_questions';

 		protected $fillable = array('question','order','elements','min','max');


 	} 