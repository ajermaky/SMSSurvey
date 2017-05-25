<?php

class SurveyQuestionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$questions = SurveyQuestions::where('order','>',0)->orderBy('order')->get();
		return View::make('pages.questions.index', compact('questions'));

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
		$lastQuestion = SurveyQuestions::where('order','>',0)->orderby('order','DESC')->first();
		if(!$lastQuestion){
			SurveyQuestions::create(array('order'=>1));

		}else{
		    SurveyQuestions::create(array('order'=>$lastQuestion->order+1));
		}

		return Redirect::route('surveyquestions.index');
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
		$questions = SurveyQuestions::where('order','>',0)->orderBy('order')->get();
		return View::make('pages.questions.edit',compact('questions'));
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
		$ids = Input::get('id');
		$questions = Input::get('question');
		$elements = Input::get('elements');
		$mins = Input::get('min');
		$maxs = Input::get('max');
		$orders = Input::get('order');

		for($i = 0; $i<count($ids);$i++){
			$question = SurveyQuestions::find($ids[$i]);
			$question->update(array('question'=>$questions[$i],'elements'=>$elements[$i],'min'=>$mins[$i],'max'=>$maxs[$i],'order'=>$orders[$i]));

		}

		return Redirect::route('surveyquestions.index');


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
		$toDeleteQuestion=SurveyQuestions::find($id);
		$questions= SurveyQuestions::where('order','>',$toDeleteQuestion->order)->get();
		$toDeleteQuestion->delete();

		foreach($questions as $question){
			//echo $question->order;
			$question->order= ($question->order)-1;
			$question->save();

		}
		return Redirect::route('surveyquestions.index');
	}


}
