<?php
class Settings extends Eloquent{
	
	protected $table = 'settings';

 	protected $fillable = array('*');

 	public static function getDelimiter(){
 		return Settings::first()->delimiter;
 	}
}