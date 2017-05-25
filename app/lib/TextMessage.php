<?php
use Illuminate\Support\Facades\Log;

class TextMessage{
		
		const SMSPATH="/var/spool/sms/smssurvey/";
		const INCOMING="incoming/";
		const OUTGOING="outgoing/";
		//const PASSWORD= "1234";
		const AIRTELNUMBER="s132";
		const MTNNUMBER="s192";
		//const UGXAMOUNT="4000;"

		public static function getTextData($filename){
			try{

				//$file = fopen(self::SMSPATH.self::INCOMING.$filename,"r");
                //Textlog::info("Get Text Data of ".$filename);
				$file = fopen($filename,"r");
			}catch(Exception $e){
				return false;
                TextLog::error("Unable to Get Text Data of ".$filename);


            }
			
			//first line in $file is going to be From: 
			$from = fgets($file);
			//looop until we get a newline.
			while((fgets($file))!="\n");

			//now we grab entire body of the message, which is form newline to end.
            $body="";
            while(($line=(fgets($file)))){
            	$body.=$line;
            }
        	fclose($file);

        	//trim string 
        	$from = trim(strstr($from,' '));
        	
        	//return data as an array. 
        	return array('phone'=>$from,'message'=>trim($body));


		}

		public static function sendErrorText($filename,$question=NULL){
            //Log::info("Sending Error Text Data of ".$filename);
            $data = self::getTextData($filename);
			$invalid = Questions::where('surveys_id','=',Surveys::getCurrent()->id)->where('order','=',SurveyQuestions::$INVALID)->first();
      if($question){
			$data['message']=($invalid->question).$question->question;
			}else{
			$data['message']=($invalid->question).$data['message'];
      }
      return TextMessage::sendText($data['phone'],$data['message']);
		}

		public static function sendText($phoneNumber, $message,$queue=NULL){
            //Log::info("Sending text message to '$phoneNumber' with '$message'");
			$textMessage = "To: $phoneNumber\n\n$message";
			
			$modem='Modem';
			if(Utils::isAirtel($phoneNumber)){
				$modem = "airtel";
			}else if(Utils::isMTN($phoneNumber)){
				$modem = "mtn";
			}
			if($queue){
				//$textMessage ="To: $phoneNumber\nQueue: $modem\n\n$message";
			}
			//echo $phoneNumber. " ". $message;
			//echo $textMessage;
			$file = fopen(self::SMSPATH.self::OUTGOING.$modem.".".microtime(true), "w");
			//echo $textMessage;
			fwrite($file, $textMessage);
			fclose($file);						
			//makes sure that file names are unique.
			usleep(50);


		}

		
		public static function parseMessage($message){
			//echo $message;
			//echo Settings::getDelimiter();
			//var_dump(explode($message,Settings::getDelimiter()));
			$messagearray =  explode(Settings::getDelimiter(), $message);
            if(count($messagearray)<=1){
                $message = preg_replace('/(\s)+/',' ',$message);
                $messagearray = explode(' ', $message);
            }
            return $messagearray;
		}

        public static function sendUGX($phone){
            if(Utils::isMTN($phone)){
                TextLog::info("Sending UGX to MTN for $phone");
                self::sendText(self::MTNNUMBER, "GIVE $phone ".Settings::first()->ugx,true);
                //$settings= Settings::first();

                //self::sendText($settings->mtn_phonenumber, "Send $phone ".$settings->ugx." UGX");

            }else if(Utils::isAirtel($phone)){
                TextLog::info("Sending UGX to AIRTEL $phone");
                self::sendText(self::AIRTELNUMBER, "2u $phone ".Settings::first()->ugx." ".Settings::first()->airtel_password,true);
            }else{
                TextLog::error("Unable to send UGX! for $phone");

            }

        }

		public static function getModemFromMessage($filename){
			try{

				//$file = fopen(self::SMSPATH.self::INCOMING.$filename,"r");
				$file = fopen($filename,"r");
			}catch(Exception $e){
				return false;

			}
			
			//first line in $file is going to be From: 
			$line = fgets($file);
			//looop until we get a newline.
			while($line && (strpos($line,"Modem: ")===FALSE)){
				//echo $line;
				$line = fgets($file);

			}
			
			$modemname  = trim(strstr($line,' '));
			return Modems::where("modem_name","=",$modemname)->first();
			

		}

    public static function getReportData($filename)
    {


        //first line in $file is going to be From:
        $from = file_get_contents($filename);
        //looop until we get a newline.
        $lines = explode(PHP_EOL,$from);
        $arr = array();
        foreach($lines as $line){
            $subcomponent = explode(": ",$line);
            if(count($subcomponent)==2){
                $arr[$subcomponent[0]]=$subcomponent[1];
            }
        }

        return $arr;


    }

}
