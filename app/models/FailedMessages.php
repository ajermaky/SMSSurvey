<?php
	class FailedMessages extends Eloquent{
		protected $table = 'failed_messages';
		protected $fillable = array('*');

		public static function updateFailedMessage($id,$message){
				$failed = FailedMessages::where('phone_numbers_id','=',$id)->where('message','=',$message)->first();
				if(!$failed){
					$failed = new FailedMessages;
					$failed->phone_numbers_id = $id;
                    $failed->message=$message;
					$failed->attempts = 0;
                    TextLog::info("Artisan FAILED: New Failed Message created for id: ". $id. " and message: $message");

				}
				if($failed->attempts<3){
					$failed->attempts +=1;
					$failed->save();
                    TextLog::info("Artisan FAILED: Old Failed Message updated for id: ". $id. " and message: $message");
                    return true;
				}
				return false;

		}

		public static function deleteFailedMessage($id,$message){
            $failed = FailedMessages::where('phone_numbers_id','=',$id)->where('message','=',$message)->first();
			if(!$failed){
				return;
			}
			$failed->delete();
            TextLog::info("Artisan SENT: Failed Message deleted");


        }


	}