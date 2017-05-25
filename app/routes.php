<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');
Route::post('/start', 'HomeController@start');
Route::post('/sendnoresponses', 'HomeController@sendNoResponses');

Route::post('/end', 'HomeController@stop');

Route::get('surveyquestions/edit','SurveyQuestionsController@edit');
Route::put('surveyquestions/edit','SurveyQuestionsController@update');
//Route::get('settings', 'SettingsController@index');
Route::post('settings/edit', 'SettingsController@edit');
Route::put('settings/edit', 'SettingsController@update');
Route::delete('phonenumbers','PhoneNumbersController@delete');
Route::get('phonenumbers/failed','PhoneNumbersController@failed');
//Route::delete('modem/{modem}','ModemController@reset');
Route::resource('modem','ModemController');
Route::resource('phonenumbers','PhoneNumbersController');
Route::resource('settings','SettingsController', ['only'=>['index']]);
Route::resource('surveyquestions', 'SurveyQuestionsController');

