<?php
	class Utils{

		public static function surveyToCSV1(){
			$questions = Questions::getCurrentQuestions();
			if(!$questions){
				return;
			}
			$data = array();
			$questionIndex = 1;
			foreach ($questions as $question) {
				array_push($data, array("Question ".($questionIndex++).': '.$question->question));
				
				$currentQuestion = array("Phone");
				for($i = 1; $i<=$question->elements;$i++){
					array_push($currentQuestion, "Answer ".$i);

				}
				array_push($data, $currentQuestion);

				$answerData = SentQuestions::getAnswers($question->id);
				foreach($answerData as $answer){
					$currentAnswer = array(PhoneNumbers::find($answer->phone_numbers_id)->phone);
					foreach(TextMessage::parseMessage($answer->answer) as $val){
						array_push($currentAnswer,$val);
					}
					array_push($data, $currentAnswer);
				}
				array_push($data, array());

			}
			//print_r($data);
			$handle = fopen(public_path().'/assets/surveys/Survey_'.Surveys::getCurrent()->id.'.csv','w');
			foreach($data as $line){
				fputcsv($handle, $line);
			}
			fclose($handle);
		}

		public static function surveyToCSV(){
			$questions = Questions::getCurrentQuestions();
			if(!$questions){
				return;
			}
			$data = array();
			$header = array("PhoneNumber");
			$questionIndex=1;
			foreach($questions as $question){
				array_push($header, "Question ".($questionIndex++).': '.$question->question);
			}
			array_push($data, $header);
			$answers = SentQuestions::where('surveys_id','=',Surveys::getCurrent()->id)->where('answer','!=',"")->orderBy('phone_numbers_id')->orderBy('id')->get();

			$row=array();
			$current_phone =0;
			foreach($answers as $answer){
				if($answer->phone_numbers_id!=$current_phone){
					array_push($data,$row);
					$row=array();
					$current_phone = $answer->phone_numbers_id;
					array_push($row, PhoneNumbers::find($current_phone)->phone);

				}
				array_push($row,$answer->answer);


			}
			array_push($data, $row);
			$handle = fopen(public_path().'/assets/surveys/Survey_'.Surveys::getCurrent()->id.'.csv','w');
			foreach($data as $line){
				//print_r($line);
				fputcsv($handle, $line);
			}
			fclose($handle);


		}

		public static function isAirtel($phoneNumber){
			if(self::isModem($phoneNumber,"25675")||self::isModem($phoneNumber,"25670")){
				return true;
			}

			return false;
		}

		public static function isMTN($phoneNumber){
			if(self::isModem($phoneNumber,"25677")||self::isModem($phoneNumber,"25678")){
				return true;
			}

			return false;
		}

		private static function isModem($string,$needle){
			return strpos($string,$needle)===0;
		}


		public static function sendNoResponses(){
			if(!Surveys::getCurrent()){
				return;
			}
			$unanswers = SentQuestions::where('surveys_id','=',Surveys::getCurrent()->id)->where('answer','=',"")->get();
			$noanswerText = SurveyQuestions::where('order','=',SurveyQuestions::$UNANSWERED)->first();

			foreach($unanswers as $unanswered){
                $phone=  PhoneNumbers::find($unanswered->phone_numbers_id)->phone;
                TextLog::info("Sending unanswered resend text for $phone");
				TextMessage::sendText($phone,$noanswerText->question);
			}
		}


        public static function getMessagesToResend(){
            $survey=Surveys::getCurrent();
            if($survey){
                $sent_questions = $survey->sent_questions()->where('answer','=',"")->get();
                foreach($sent_questions as $sent_question){
                    $report_messages = $sent_question->report_messages()->get();

                    $sent_question->state =true && (count($report_messages)>0);

                    foreach($report_messages as $report_message){
                        $status_code =$report_message->status_code;

                        if((($status_code>=32 && $status_code<=37)||($status_code<=2))){
                            $sent_question->state=false;
                        }
                    }




                }


                return $sent_questions->filter(function($question){
                    return $question->state;
                });
            }
        }
	}