<?php

class SettingsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//

		$questions = SurveyQuestions::where('order','<',0)->orderBy('order','DESC')->get();
		//delimiter
		$delimiter = Settings::getDelimiter();
		$settings = Settings::first();
		return View::make('pages.settings.index',compact('questions','delimiter','settings'));	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		//
		$questions = SurveyQuestions::where('order','<',0)->orderBy('order','DESC')->get();
		$delimiter = Settings::getDelimiter();
		$settings = Settings::first();
		return View::make('pages.settings.edit',compact('questions','delimiter','settings'));	
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		//
		$prereminder = SurveyQuestions::where('order','=',SurveyQuestions::$PREREMINDER)->first();
		$closed = SurveyQuestions::where('order','=',SurveyQuestions::$CLOSED)->first();
		$invalid = SurveyQuestions::where('order','=',SurveyQuestions::$INVALID)->first();
		$end = SurveyQuestions::where('order','=',SurveyQuestions::$END)->first();
		$noresponse = SurveyQuestions::where('order','=',SurveyQuestions::$UNANSWERED)->first();

		$prereminder->question = Input::get('pre_reminder');
		$closed->question=Input::get('closed');
		$invalid->question=Input::get('invalid');
		$end->question=Input::get('end');
		$noresponse->question=Input::get('noresponse');
		$settings = Settings::all()->first();
		$settings->delimiter=(Input::get('delimiter'));
		$settings->prereminder_time = Input::get('pre_reminder_time');
		$settings->resend_short = Input::get('resend_short');
		$settings->resend_short_time = Input::get('resend_short_time');
		$settings->resend_long = Input::get('resend_long');
		$settings->resend_long_time = Input::get('resend_long_time');
		$settings->ugx=Input::get('ugx');
		$settings->airtel_password=Input::get('airtel_password');
		$settings->mtn_phonenumber=Input::get('mtn_phonenumber');
		$noresponse->save();
		$closed->save();
		$invalid->save();
		$prereminder->save();
		$end->save();
		$settings->save();

		return Redirect::route('settings.index');

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function showQuestions(){
		
	}

	public function editQuestions(){

	}
	public function updateQuestions(){

	}


}
