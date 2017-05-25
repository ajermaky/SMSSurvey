<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
	app_path().'/lib',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

Event::listen('cron.collectJobs', function() {
    Cron::add('timechecker', '* * * * *', function() {
                    // Do some crazy things unsuccessfully every minute
      $survey = Surveys::getCurrent();
      if(!$survey){
        return null;
      }
        $settings = Settings::first();
        $total_attempts = $settings->resend_short + $settings->resend_long;
        $short_time = ($settings->resend_short_time)*60;
        $long_time = ($settings->resend_long_time)*3600;
        $current_time = time();

        $unansweredQuestions = SentQuestions::getNoResponses($total_attempts);
//echo 'hello';
//print_r($unansweredQuestions);

        foreach($unansweredQuestions as $unanswered){

        	$time = strtotime($unanswered->created_at);
       		$diff = $current_time-$time;
       		//echo $diff;
       		$unanswered->time_sent+=1;
       		if($unanswered->times_sent <= $settings->resend_short){
//					var_dump($diff);

       			//if($diff > $short_time*($unanswered->times_sent)){
				if($diff > ($unanswered->time_sent)*$short_time){
       			    //echo $unanswered->id;
					//echo $diff;
       				$phone = PhoneNumbers::find($unanswered->phone_numbers_id);
       				$question = Questions::find($unanswered->questions_id);
       				TextMessage::sendText($phone->phone, "We did not get a response in the last " .((int)($diff/60)). " minutes.".$question->question);
       				$unanswered->save();

       			}
       		}else{
				if($diff > $long_time*($unanswered->time_sent-$unanswered->resend_short)){
       				$phone = PhoneNumbers::find($unanswered->phone_numbers_id);
       				$question = Questions::find($unanswered->questions_id);
       				TextMessage::sendText($phone->phone, $question->question);
       				$unanswered->save();
       			}
       		}
        }


        return null;
    });
    Cron::add('prereminder', '* * * * *', function(){
      $survey = Surveys::getCurrent();
      if(!$survey){
        return null;
      }
      $settings = Settings::first();
      $current_time = time();
      $time = strtotime($survey->created_at);
      if(($current_time - $time) > 60*$settings->prereminder_time){
        if($settings->prereminder_on){
          Artisan::call('text',array('status'=>'SENDSURVEY','filename'=>'filler'));
          $settings->prereminder_on = 0;
          $settings->save();
        }
      }
    });

    Cron::add('failedmessages', '*/10 * * * *', function(){
        $survey = Surveys::getCurrent();
        if(!$survey){
            return null;
        }
        TextLog::info("im in failedmessages");
        $failedmessages = FailedMessages::where('attempts','<',3)->get();
        foreach($failedmessages as $failedmessage){
            $phone = PhoneNumbers::find($failedmessage->phone_numbers_id);
            if(!$phone){
                TextLog::error("TIMECHECKER: no phone number in database");
            }
            TextMessage::sendText($phone->phone,$failedmessage->message);
        }
    });

    Cron::add('report_messages', '*/10 * * * *', function(){
        $sent_questions = Utils::getMessagesToResend();
        foreach($sent_questions as $sent_question){
            $phone = PhoneNumbers::find($sent_questions->phone_numbers_id);
            $question = Questions::find($sent_questions->questions_id);
            TextMessage::sendText($phone->phone,$question->question);
        }
    });

 //   Cron::add('example2', '*/2 * * * *', function() {
        // Do some crazy things successfully every two minute
   //     return null;
   // });

    Cron::add('disabled job', '0 * * * *', function() {
        // Do some crazy things successfully every hour
    }, false);

});


Event::listen('survey.end', function(){
  if(Surveys::getCurrent()){
      TextLog::info("Ending Survey");
	Utils::surveyToCSV();
	Surveys::endSurvey();
  }

});

Event::listen('survey.start', function(){
	if(Surveys::getCurrent()){
		Event::fire('survey.end');

	}
    TextLog::info("Starting Survey");

    Surveys::startSurvey();
	$surveyQuestions = SurveyQuestions::all();
	foreach($surveyQuestions as $squestion){
		$question = new Questions;
		$question->surveys_id = Surveys::getCurrent()->id;
		$question->question = $squestion->question;
		$question->order = $squestion->order;
		$question->elements = $squestion->elements;
		$question->min = $squestion->min;
		$question->max = $squestion->max;
		$question->save();
	}
  $settings = Settings::first();
  $settings->prereminder_on = 1;
  $settings->save();

});
Event::listen('modem.addmessage', function($filename){
$modem = TextMessage::getModemFromMessage($filename);
   if($modem){
      $modem->messages_sent++;
      $modem->save();
    }
});

Event::listen('modem.addairtime', function($filename){
$modem = TextMessage::getModemFromMessage($filename);
   if($modem){
      $modem->airtime_sent+= Settings::first()->ugx;
      $modem->save();
    }
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
