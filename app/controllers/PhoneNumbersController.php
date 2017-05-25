<?php

class PhoneNumbersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$phonenumbers = PhoneNumbers::orderBy("attempts",'desc')->get();
		return View::make('pages.phonenumbers.index', compact('phonenumbers'));
	}

	public function failed(){
		$phonenumbers = FailedMessages::orderBy("attempts",'desc')->get();
		foreach($phonenumbers as $phone){
			$phone->phone = PhoneNumbers::find($phone->id)->phone;
		}
		return View::make('pages.phonenumbers.failed', compact('phonenumbers'));
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
		$phonenumbers = Input::get('phonenumbers');
		$phones = explode(',',$phonenumbers);
		//echo $phonenumbers;
		foreach($phones as $phone){
			$toAdd = new PhoneNumbers;
			$toAdd->phone = trim($phone);
			$toAdd->save();
			//PhoneNumbers::create(array('phone'=>trim($phone),'failed_responses'=>3));
			//echo trim($phone);
		}
		return Redirect::route('phonenumbers.index');
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
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

	public function delete(){
		$phones = Input::get('phone');
		PhoneNumbers::destroy($phones);
		return Redirect::Route('phonenumbers.index');
	}


}
