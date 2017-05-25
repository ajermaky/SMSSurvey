<?php

 	class Questions extends Eloquent{

 		protected $table = 'questions';

 		protected $fillable = array('surveys_id','question','order','elements','min','max');

 		public static function getCurrentQuestions(){

 			return Questions::where('surveys_id','=',Surveys::getCurrent()->id)->where('order','>',0)->get();
 		}

 	} 