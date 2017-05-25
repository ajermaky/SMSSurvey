<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrereminderCheck extends Migration {

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
      $table->boolean('prereminder_on')->default(0)->after('prereminder_time');
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
      $table->dropColumn('prereminder_on');
		});
	}

}
