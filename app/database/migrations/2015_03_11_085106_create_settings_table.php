<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('delimiter',1)->default('#');
			$table->integer('resend_short');
			$table->integer('resend_short_time');
			$table->integer('resend_long');
			$table->integer('resend_long_time');
			$table->integer('prereminder_time');
			$table->timestamps();


		});
		$settings = new Settings;
		$settings->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
