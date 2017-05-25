<?php

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TextCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'text';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Handle Text Messages';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
		$status = $this->argument('status');
		$filename = $this->argument('filename');
		if(!$status || !$filename){
			return null;
		}
		switch($status){
			case "FAILED":
				$data = TextMessage::getTextData($filename);
				$phone = PhoneNumbers::where('phone','=',$data['phone'])->first();
				if(!$data || !$phone){
                    TextLog::error("Artisan FAILED: no data or phonenumber");
					return null;
				}
				if(FailedMessages::updateFailedMessage($phone->id,$data['message'])){
                    $message = $data['message'];
                    TextLog::error("Aritsan FAILED: Failed message for file for phonenumber '$phone->phone' and message '$message', located in '$filename'");
                    //TextMessage::sendText($phone->phone, $data['message']);
				}

				break;


			case "SENT":
                $messageid = $this->argument("message_id");

				$data = TextMessage::getTextData($filename);
                if(!$data){
                    TextLog::error("Artisan SENT: no data");
                    return null;
                }
                $phone = PhoneNumbers::where('phone','=',$data['phone'])->first();


				if($phone){
					//$phone->id;

					FailedMessages::deleteFailedMessage($phone->id,$data['message']);


				}else{
                    if(!$data){
                        TextLog::error("Artisan SENT: no phone number in database");
                        return null;
                    }
                }
				$question=NULL;
				if(Surveys::getCurrent())
				$question = Questions::where('surveys_id','=',Surveys::getCurrent()->id)->where('question','=',$data['message'])->first();
				//echo $question->question;
				Event::fire('modem.addmessage',array($filename));

				if(strpos($data['phone'],'s')!==TRUE){
					Event::fire('modem.addairtime',array($filename));

				}
		        if(!$question || $question->order<0){
                    $reportMessage = new ReportMessage;
                    //$reportMessage->sent_questions_id=null;
                    $reportMessage->message_id=$messageid;
                    $reportMessage->surveys_id = Surveys::getCurrent()->id;
                    $reportMessage->phone_numbers_id = $phone->id;
                    $reportMessage->message = $data['message'];
                    $reportMessage->status_code=-1;
                    $reportMessage->save();
                    TextLog::error("Error: No Question associated for $phone->phone in $filename. Saving report message");
		            return;
		        }
		        if($question->order >0){
                    TextLog::info("Adding a new question for $phone->phone");
                    SentQuestions::insertQuestion($question->id, $phone->id, $messageid);
				}
				break;

			case "RECEIVED":
				Event::fire('modem.addmessage',array($filename));

		        $survey= Surveys::getCurrent();
                $data = TextMessage::getTextData($filename);
                if(!$survey){
                    TextLog::error("No Survey in progress for received text in $filename");
					$finalText = SurveyQuestions::where('order','=',SurveyQuestions::$CLOSED)->first();
					TextMessage::sendText($data['phone'],$finalText->question);
                }

				$phone = PhoneNumbers::where('phone','=',$data['phone'])->first();
		        if(!$phone){
                    TextLog::error("No Phone Number in db for received text message in $filename");
		       		 return ;
		        }
						//$question = Questions::where('surveys_id','=',Surveys::getCurrent()->id)->where('question','=',trim($data['message']))->first();
				$currentQuestion = SentQuestions::getUnansweredQuestion($phone->id);
				if($currentQuestion) {
					$question = Questions::find($currentQuestion->questions_id);
					$wellFormatted = true;
					$numOfAnswers = 0;
					//echo $data['message']; 
					$datastr = TextMessage::parseMessage($data['message']);
					$numOfAnswers=count($datastr);					
					for($i=0;$i<$numOfAnswers;$i++) {
						//$numOfAnswers++;
						$val = trim($datastr[$i]);
						$checkMin = ($val >= $question->min)? true : false;
						$checkMax = ($val <= $question->max)? true : false;
						if(!is_numeric($val) || !$checkMin || !$checkMax) {
                            TextLog::error("Answer did not contain numbers, or was not withing the range for $phone->phone in $filename");
							$wellFormatted = false;
							break;
						}
					}

					if($numOfAnswers!=$question->elements){
			//	echo $numOfAnswers . ' ' . $question->elements;
                        TextLog::error("Answer did not contain enough answers for $phone->phone in $filename");
						$wellFormatted = false;
					}
				//	var_dump( $wellFormatted);
					if($wellFormatted) {
						//SentQuestions::updateUnansweredQuestion($question->id,$phone->id,$data['message']);
						$currentQuestion->answer = $data['message'];
						$currentQuestion->save();
						$nextQuestion = SentQuestions::getNextQuestion($question->order,$phone->id);

				
						if($nextQuestion) {
							//Send next question
                            TextLog::info("Sending next question for $phone->phone");

                            TextMessage::sendText($data['phone'], $nextQuestion->question);
						} else {
						//They are done with the survey send airtime
                            TextLog::info("Survey done, sending UGX for $phone->phone");
							$finalText = SurveyQuestions::where('order','=',SurveyQuestions::$END)->first();
							TextMessage::sendText($data['phone'],$finalText->question);
							//UGX
							TextMessage::sendUGX($data['phone']);
						}
					} else {

                        TextLog::info("Message Received was incorrect. Resending for $phone->phone in $filename");
						TextMessage::sendErrorText($filename,$question);
					

					}
				} else {
				//TODO: CLOSED
					//$finalText = Questions::where('order','=',SurveyQuestions::$CLOSED)->where('surveys_id','=',Surveys::getCurrent()->id)->first();
					//TextMessage::sendText($data['phone'],$finalText->question);
				}
				break;

			case "SENDSURVEY":
				//Event::fire('survey.start');
				$firstQuestion = SentQuestions::getNextQuestion(0);
				$phones = PhoneNumbers::all();
				foreach($phones as $phone){
                    TextLog::info("Starting survey for $phone->phone");
					TextMessage::sendText($phone->phone,$firstQuestion->question);
				} 

				break;

			case "PREREMINDER":
				Event::fire('survey.start');
				$settings = Settings::first();
				$prereminder = Questions::where('surveys_id','=',Surveys::getCurrent()->id)->where('order','=',-1)->first();
				$message = sprintf($prereminder->question,$settings->prereminder_time);
				$phones = PhoneNumbers::all();
				foreach($phones as $phone){
					echo $phone->phone;
                    TextLog::info("Starting survey for $phone->phone");
                    TextMessage::sendText($phone->phone, $message);
                    TextMessage::sendText($phone->phone,"Please answer in the format 10#20#30#40 or 10 20 30 40. You can use either space or # to separate the numbers but not both.");
                    TextMessage::sendUGX($phone->phone);
				}
				break;
            case "REPORT":
                $reportdata = TextMessage::getReportData($filename);

                $report = ReportMessage::where('message_id','=',$reportdata['Message_id'])->first();
                if(!$report){
                    TextLog::error("No report can be found for filename: $filename and message id". $reportdata['Message_id']);
                    return null;
                }

                $status = explode(',',$reportdata['Status']);
                $report->status_code=$status[0];
                $report->status_short=$status[1];
                $report->status = $status[2];
                $report->save();
                TextLog::info("Report saved for $filename and message id". $reportdata['Message_id']);

                if($report->sent_questions_id==null){
                    TextLog::info("Report message  was not for question. Running immediate analysis");

                    $reports = ReportMessage::where('surveys_id','=',Surveys::getCurrent()->id)->where('sent_questions_id','=',-1)->where('phone_numbers_id','=',$report->phone_numbers_id)->where('message','=',$report->message)->get();
                    $state = false;
                    foreach($reports as $report1){
                        $status_code =$report1->status_code;
                        if(($status_code>=0 &&$status_code <=2) ||($status_code>=32 && $status_code<=37)){
                            $state = true;
                            break;
                        }

                    }

                    if(!$state){
                        $phone = PhoneNumbers::find($report->phone_numbers_id);
                        $message = $report->message;
                        TextLog::info("Based on report message, resending message $message for phone ". $phone->phone);

                        TextMessage::sendText($phone->phone,$message);
                    }
                }
                break;

            case "TEST":
                $sent_questions = Utils::getMessagesToResend();
                foreach($sent_questions as $sent_question){
                    echo 'hi';
                    $phone = PhoneNumbers::find($sent_question->phone_numbers_id);
                    $question = Questions::find($sent_question->questions_id);
                    TextMessage::sendText($phone->phone,$question->question);
                }
                break;

			default:
				break;

		}


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('status', InputArgument::REQUIRED, 'The status of the text message.'),
			array('filename', InputArgument::REQUIRED, 'The filename of the text message.'),
            array('message_id', InputArgument::OPTIONAL, 'The id of the text message.'),

        );
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		/*return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),

		);*/
		return array();
	}

}
