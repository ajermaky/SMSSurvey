<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		//Utils::surveyToCSV();
    	$path = public_path().'/assets/surveys/';
		$dir = opendir($path);
		$files = array();
		while (false !== ($file = readdir($dir))) { 
			if($file!=='.'&& $file!=='..'){
        		array_push($files,$file);
        		//echo filemtime($path.$file)."&nbsp;&nbsp;".$file;
        	}
     	}

     	closedir($dir);

     	usort($files, function($a,$b) use ($path) {
     		return filemtime($path.$a)<filemtime($path.$b);
     	});
     	$fileobjs = array();
     	foreach($files as $file){
     		$fileobj = new stdClass;
     		$fileobj->name = $file;
     		$fileobj->date = date('m/d/y',filemtime($path.$file));
     		array_push($fileobjs,$fileobj);
     	}

		return View::make('pages.home',compact('fileobjs'));

	}

	public function start(){
    $file='/var/www/smssurvey/app/storage/cron.lock';
    if(file_exists($file))
      unlink($file);
		Artisan::call('text',array('status'=>'PREREMINDER','filename'=>'filler'));

		return Redirect::to('/');
	}

	public function stop(){
    Event::fire('survey.end');
		return Redirect::to('/');

	}

	public function sendNoResponses(){
		Utils::sendNoResponses();
		return Redirect::to('/');

	}

}
