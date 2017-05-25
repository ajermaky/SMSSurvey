<?php

class ModemController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//$razr1 = count(glob(TextMessage::SMSPATH.TextMessage::OUTGOING."RAZR1*"))+count(glob(TextMessage::SMSPATH.TextMessage::INCOMING."RAZR1*"));
		//$razr2 = count(glob(TextMessage::SMSPATH.TextMessage::OUTGOING."RAZR2*"))+count(glob(TextMessage::SMSPATH.TextMessage::INCOMING."RAZR2*"));

		$modems = Modems::all();
		return View::make('pages.modem.index',compact('modems'));
	}


	public function resetMessage($id){
		$modem = Modem::find($id);
		$modem->messages_sent=0;
		$modem->save();
		return Redirect::to('modem');

	}
	public function resetAirtime($id){
		$modem= Modem::find($id);
		$modem->airtime_sent=0;
		$modem->save();
		return Redirect::to('modem');

	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		//return View::make('pages.modem.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		//echo Input::get('modem_name');
		$modem = new Modems;
		$modem->modem_name = Input::get('modem_name');
		$modem->save();
		return Redirect::to('modem');
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
		Modems::destroy($id);
		return Redirect::to('modem');
	}


}
