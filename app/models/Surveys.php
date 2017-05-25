<?php
	class Surveys extends Eloquent{
		protected $table='surveys';
		protected $fillable = array('*');

		public static function getCurrent(){
			return Surveys::where('is_current','=',1)->get()->first();
		}

		public static function endSurvey(){
			$survey = Surveys::getCurrent();
			if(!$survey)
				return;
			$survey->is_current = 0;
			$survey->save();
		}

		public static function startSurvey(){
			$survey = new Surveys;
			$survey->is_current = 1;
			$survey->save();
		}

        public function sent_questions(){
            return $this->hasMany('SentQuestions','surveys_id','id');
        }
	}