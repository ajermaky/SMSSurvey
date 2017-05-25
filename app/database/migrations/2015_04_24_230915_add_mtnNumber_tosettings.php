<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMtnNumberTosettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			//
			$table->string("mtn_phonenumber")->after("airtel_password");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			//
		});
	}

}
