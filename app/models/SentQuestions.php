<?php
	class SentQuestions extends Eloquent{

		protected $table='sent_questions';
		protected $fillable = array('*');

		public static function getAnswers($id){
			return SentQuestions::where('questions_id','=',$id)->get();
		}

		public static function insertQuestion($questionId, $phoneId, $message_id=-1){
			if(!SentQuestions::getUnansweredQuestion($questionId,$phoneId)){
				$sentQuestions = new SentQuestions;
				$sentQuestions->surveys_id = Surveys::getCurrent()->id;
				$sentQuestions->phone_numbers_id= $phoneId;
				$sentQuestions->questions_id = $questionId;
				$sentQuestions->save();

                if($message_id!=-1){
                    $reportMessage = new ReportMessage;
                    $reportMessage->surveys_id = Surveys::getCurrent()->id;
                    $reportMessage->phone_numbers_id= $phoneId;
                    $reportMessage->sent_questions_id=$sentQuestions->id;
                    $reportMessage->message_id=$message_id;
                    $reportMessage->status_code=-1;
                    $reportMessage->save();

                }
				//SentQuestions::create(array('surveys_id'=>Surveys::getCurrent()->id,'questions_id'=>$questionId,'phone_numbers_id'=>$phoneId));
			}

		}

		public static function getUnansweredQuestion($phoneId){
			return SentQuestions::where('surveys_id','=',Surveys::getCurrent()->id)->where('phone_numbers_id','=',$phoneId)->where('answer','=',"")->first();
			//echo $sent->id;

		}

		public static function updateUnansweredQuestion($questionId,$phoneId, $answer){
			if($unansweredQuestion = SentQuestions::getUnansweredQuestion($questionId,$phoneId)){
				$unansweredQuestion->answer = $answer;
				$unansweredQuestion->save();
				//return true;
			}
			//return false;
		}

		public static function getNoResponses($times_sent){
			return SentQuestions::where('surveys_id','=',Surveys::getCurrent()->id)->where('answer','=',"")->where('time_sent','<',$times_sent)->get();
		}
		public static function getNextQuestion($order){
			echo $order;
			$question = Questions::where('surveys_id','=',Surveys::getCurrent()->id)->where('order','=',$order+1)->first();
			/*if(!$question){
				return;
			}
			$sentQuestions = new SentQuestions;
			$sentQuestions->surveys_id= Surveys::getCurrent()->id;
			$sentQuestions->questions_id = $question->id;
			$sentQuestions->phone_numbers_id=$phoneId;
			$sentQuestions->save();*/
			return $question;

		}

        public function report_messages(){
            return $this->hasMany('ReportMessage','sent_questions_id','id');
        }
	}